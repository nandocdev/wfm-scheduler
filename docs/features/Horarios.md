# Módulo de Horarios — Centro de Contactos CSS
**Especificación Técnica v2.0**

---

## 1. Visión general

El módulo gestiona el ciclo de vida completo de los horarios de agentes: planificación, publicación, cambios de turno (swap), excepciones y registro intraday. Es la fuente de verdad para la disponibilidad real de cada agente en tiempo real.

---

## 2. Roles y permisos

| Rol                       | Capacidades                                                                            |
| ------------------------- | -------------------------------------------------------------------------------------- |
| **Administrador**         | Configuración global, parámetros de turnos, plantillas, reportes consolidados          |
| **Coordinador de equipo** | Crear/publicar horarios de su equipo, aprobar swaps, registrar excepciones y ausencias |
| **Agente**                | Ver su propio horario, solicitar swap, registrar solicitudes de permiso                |
| **Supervisor**            | Visibilidad de todos los equipos, reportes, sin edición directa                        |

---

## 3. Modelo de datos

### 3.1 Turno base (`Shift`)

```python
@dataclass
class Shift:
    shift_id: UUID
    user_id: UUID
    team_id: UUID
    date: date
    start_time: time           # Inicio del turno
    end_time: time             # Fin del turno (start + 8h)
    break_start: time          # Descanso 15 min
    lunch_start: time          # Almuerzo 45 min
    effective_hours: float = 7.0
    status: ShiftStatus        # DRAFT | PUBLISHED | MODIFIED | CANCELLED
    published_at: datetime | None = None
    created_by: UUID
    updated_at: datetime
```

### 3.2 Actividad dentro del turno (`ShiftActivity`)

```python
@dataclass
class ShiftActivity:
    activity_id: UUID
    shift_id: UUID
    activity_type: ActivityType  # WORKING | MEETING | TRAINING | PROJECT
                                 # VACATION | LEAVE | PERMISSION
    start_time: time
    end_time: time
    description: str | None = None
    created_by: UUID             # Coordinador que asignó la actividad
```

**Regla:** Las actividades no pueden solaparse entre sí ni con los bloques de descanso/almuerzo. El slot por defecto es `WORKING`.

### 3.3 Solicitud de swap (`SwapRequest`)

```python
@dataclass
class SwapRequest:
    swap_id: UUID
    requester_id: UUID           # Usuario A
    target_id: UUID              # Usuario B
    requester_shift_id: UUID
    target_shift_id: UUID
    swap_type: SwapType          # SINGLE_DAY | PERIOD
    period_start: date | None
    period_end: date | None
    status: SwapStatus           # PENDING | ACCEPTED | REJECTED
                                 # COORDINATOR_REVIEW | APPROVED | CANCELLED
    requester_reason: str | None
    target_response: str | None
    coordinator_id: UUID | None
    coordinator_notes: str | None
    created_at: datetime
    resolved_at: datetime | None
```

### 3.4 Excepción / evento posterior (`ShiftException`)

```python
@dataclass
class ShiftException:
    exception_id: UUID
    shift_id: UUID
    user_id: UUID
    exception_type: ExceptionType  # TARDINESS | ABSENCE | MEDICAL_APPOINTMENT
                                   # QUARTERLY_PERMISSION | OTHER
    started_at: datetime
    ended_at: datetime | None
    justified: bool
    justification: str | None
    registered_by: UUID            # Coordinador
    created_at: datetime
```

---

## 4. Reglas de negocio críticas

### 4.1 Construcción del horario
- Un turno dura exactamente **8 horas** brutas → **7 horas efectivas**.
- Descanso: **15 min** fijos dentro del turno.
- Almuerzo: **45 min** fijos dentro del turno.
- Una actividad no puede exceder el bloque de trabajo efectivo del día.
- No se permite solapamiento de actividades para el mismo usuario en el mismo turno.

### 4.2 Cobertura mínima (validación al publicar)
- El sistema debe validar que en cada franja horaria del día exista al menos `N` agentes activos (valor configurable por equipo/cola).
- Si la validación falla, el sistema bloquea la publicación y notifica al coordinador con el detalle de las franjas deficitarias.

### 4.3 Permiso trimestral
- Cada agente tiene derecho a **8 horas** de permiso por trimestre.
- No son acumulables entre trimestres.
- El sistema controla el saldo disponible por agente y trimestre; el coordinador no puede aprobar permisos que excedan el saldo.

### 4.4 Flujo de swap

```
Estado inicial:           PENDING
→ Aceptado por usuario B: ACCEPTED  → COORDINATOR_REVIEW
→ Rechazado por usuario B: REJECTED (fin)
→ Aprobado por coordinador: APPROVED → ambos horarios se actualizan automáticamente
→ Rechazado por coordinador: REJECTED (notifica a ambos usuarios)
```

- Un swap sólo es válido si no viola las reglas de cobertura mínima del equipo.
- El coordinador puede forzar un swap (`force_approve`) con nota de justificación, incluso si la cobertura cae por debajo del mínimo (requiere rol de Administrador o Supervisor).
- Los swaps de periodo (`PERIOD`) se deshacen automáticamente si alguno de los días intermedios tiene una excepción registrada.

### 4.5 Swap intraday
- Permitido mientras el turno esté en curso.
- Aplica las mismas reglas que un swap normal, pero el tiempo de respuesta del usuario B se limita a **15 minutos** antes de que expire automáticamente.

---

## 5. Flujo de planificación y publicación

```
1. El coordinador crea el horario para el periodo (semana/quincena/mes).
2. Asigna turnos a cada agente de su equipo.
3. Opcionalmente asigna actividades específicas (reunión, capacitación, etc.).
4. Registra excepciones previas conocidas:
   - Vacaciones aprobadas
   - Citas médicas programadas
   - Permisos trimestrales pre-solicitados
5. El sistema valida:
   a. Cobertura mínima por franja horaria
   b. Saldo de permisos trimestrales
   c. Sin solapamiento de actividades
6. Si la validación es exitosa → el coordinador publica.
7. El sistema notifica a cada agente por correo/notificación push con su horario.
8. El horario queda visible en tiempo real para todos los agentes del equipo.
```

---

## 6. Gestión intraday y registro posterior

### 6.1 Eventos que el coordinador debe registrar

| Evento                    | Tipo                   | Acción requerida                                   |
| ------------------------- | ---------------------- | -------------------------------------------------- |
| Tardanza                  | `TARDINESS`            | Registrar hora real de llegada y si es justificada |
| Ausencia                  | `ABSENCE`              | Registrar, clasificar justificada/no justificada   |
| Cita médica no notificada | `MEDICAL_APPOINTMENT`  | Registrar con evidencia pendiente                  |
| Permiso no planificado    | `QUARTERLY_PERMISSION` | Validar saldo disponible antes de aprobar          |

### 6.2 Flujo de registro de ausencia/tardanza

```
1. Coordinador detecta la ausencia/tardanza en tiempo real.
2. Marca el evento en el sistema con tipo y hora.
3. El horario del agente se actualiza en tiempo real (visible para todos).
4. En las siguientes 24-48 h (configurable), el coordinador registra la justificación.
5. Si no se registra justificación en el plazo → se marca automáticamente como "injustificada".
6. El sistema genera alerta al supervisor si un agente acumula N eventos injustificados en el mes.
```

---

## 7. Notificaciones

| Evento                                       | Destinatario         | Canal          |
| -------------------------------------------- | -------------------- | -------------- |
| Publicación de horario                       | Agente               | Email + push   |
| Solicitud de swap recibida                   | Usuario B            | Push + in-app  |
| Swap aceptado/rechazado                      | Usuario A            | Push + in-app  |
| Swap en revisión coordinador                 | Coordinador          | Email + in-app |
| Swap aprobado/rechazado                      | Ambos usuarios       | Push + in-app  |
| Cobertura mínima en riesgo                   | Coordinador          | Email + in-app |
| Permiso trimestral próximo a agotarse (≥80%) | Agente + Coordinador | In-app         |
| Ausencia/tardanza registrada                 | Agente               | In-app         |

---

## 8. API endpoints (resumen)

```
POST   /schedules                         Crear borrador de horario
PUT    /schedules/{id}/publish            Publicar horario (valida cobertura)
GET    /schedules/{id}                    Ver horario
PATCH  /schedules/{id}/shifts/{shift_id}  Modificar turno individual

POST   /activities                        Asignar actividad a turno
DELETE /activities/{id}                   Eliminar actividad

POST   /swaps                             Crear solicitud de swap
PATCH  /swaps/{id}/respond                Usuario B acepta/rechaza
PATCH  /swaps/{id}/coordinate             Coordinador aprueba/rechaza

POST   /exceptions                        Registrar excepción/ausencia/tardanza
PATCH  /exceptions/{id}/justify           Actualizar justificación

GET    /coverage?date=&team_id=           Consultar cobertura por franja
GET    /permissions/balance?user_id=      Saldo de permiso trimestral
```

---

Resumen ejecutivo
- Diseño compatible con el DDL vigente (PK bigserial).
- Representación de franjas de 5 minutos usando índices de slot (0..287) para eficiencia en agregación de cobertura.
- Evitar EXCLUDE/PG-only en tablas primarias; mantener validaciones en Actions y ofrecer opciones PG optimizadas (range/exclude) para CI/producción.

Entidades clave y relaciones (ERD textual)
- `weekly_schedules` (id, name, week_start_date, state, created_by, timestamps)
  - 1:N -> `weekly_schedule_assignments`
- `weekly_schedule_assignments` (id, weekly_schedule_id FK, employee_id FK, schedule_id FK, unique(weekly_schedule_id, employee_id))
  - Define qué `schedule` aplica al empleado en esa semana.
- `shifts` (id, weekly_schedule_assignment_id FK, employee_id FK, date, start_time, end_time, break_start, lunch_start, status, published_at, created_by, timestamps)
  - Each shift = 8h base (business rule).
- `shift_activities` (id, shift_id FK, activity_type, start_slot smallint, end_slot smallint, description, created_by, timestamps)
  - start_slot/end_slot = integers in [0,287), end_slot exclusive.
  - Constraint: start_slot < end_slot.
- `shift_exceptions` / reuse `attendance_incidents` (existing) — link to shift_id if applicable.
- `shift_swap_requests` (id, requester_employee_id, target_employee_id, requester_shift_id, target_shift_id, type, period_start, period_end, status, coordinator_id, notes, timestamps)
- `coverage_requirements` (id, team_id FK, date, slot_index smallint, required_min smallint)
  - Optional persisted per team/day/slot or computed configuration (team-level required_min default).
- `coverage_snapshots` (id, team_id, date, slot_index, assigned_count int, required_min int, deficit boolean, created_at)
  - Populated at publish time (materialized snapshot to show coordinators).

Schema DDL (pseudocódigo SQL — adapt to Laravel migrations)

- `shifts`
```sql
CREATE TABLE shifts (
  id bigserial PRIMARY KEY,
  weekly_schedule_assignment_id bigint NOT NULL REFERENCES weekly_schedule_assignments(id) ON DELETE CASCADE,
  employee_id bigint NOT NULL REFERENCES employees(id) ON DELETE CASCADE,
  date date NOT NULL,
  start_time time NOT NULL,
  end_time time NOT NULL,
  break_start time,
  lunch_start time,
  status varchar(20) DEFAULT 'draft' NOT NULL,
  published_at timestamp NULL,
  created_by bigint NULL REFERENCES users(id),
  created_at timestamp,
  updated_at timestamp,
  CONSTRAINT shifts_employee_date_unique UNIQUE (employee_id, date)
);
CREATE INDEX shifts_employee_idx ON shifts(employee_id);
CREATE INDEX shifts_team_date_idx ON shifts(date, employee_id); -- use join via employees.team_id
```

- `shift_activities`
```sql
CREATE TABLE shift_activities (
  id bigserial PRIMARY KEY,
  shift_id bigint NOT NULL REFERENCES shifts(id) ON DELETE CASCADE,
  activity_type varchar(30) NOT NULL,
  start_slot smallint NOT NULL, -- 0..287
  end_slot smallint NOT NULL,   -- exclusive
  description text,
  created_by bigint NULL REFERENCES users(id),
  created_at timestamp,
  updated_at timestamp,
  CONSTRAINT shift_activity_slot_check CHECK (start_slot >= 0 AND end_slot <= 288 AND start_slot < end_slot)
);
CREATE INDEX shift_activities_shift_idx ON shift_activities(shift_id);
CREATE INDEX shift_activities_slot_idx ON shift_activities(start_slot, end_slot);
```

- `coverage_requirements` (optional config)
```sql
CREATE TABLE coverage_requirements (
  id bigserial PRIMARY KEY,
  team_id bigint NOT NULL REFERENCES teams(id) ON DELETE CASCADE,
  date date NOT NULL,
  slot_index smallint NOT NULL, -- 0..287
  required_min smallint NOT NULL DEFAULT 0,
  UNIQUE(team_id, date, slot_index)
);
CREATE INDEX coverage_requirements_team_date_idx ON coverage_requirements(team_id, date);
```

- `coverage_snapshots` (computed on publish)
```sql
CREATE TABLE coverage_snapshots (
  id bigserial PRIMARY KEY,
  team_id bigint NOT NULL REFERENCES teams(id) ON DELETE CASCADE,
  date date NOT NULL,
  slot_index smallint NOT NULL,
  assigned_count int NOT NULL,
  required_min int NOT NULL,
  deficit boolean NOT NULL,
  created_at timestamp NOT NULL DEFAULT now(),
  UNIQUE(team_id, date, slot_index)
);
CREATE INDEX coverage_snapshots_team_date_idx ON coverage_snapshots(team_id, date);
```

Cobertura y algoritmo de validación (Publish)
- Representación: cada `shift` → genera un rango de slots [start_slot, end_slot) (compute from start_time).
- Para cada team/date:
  - Build a per-slot aggregate:
    SELECT slot_index, COUNT(DISTINCT employee_id) AS assigned_count
    FROM (unnest slot ranges for all shifts/shift_activities) GROUP BY slot_index
  - Join with `coverage_requirements` (or team default k) and detect slots where assigned_count < required_min.
- Si existe alguna franja deficitara → bloqueo y respuesta con lista de {slot_index, start_time, assigned_count, required_min}.
- Implementar dentro de `PublishWeeklyScheduleAction`:
  - DB::transaction + acquire advisory lock per team+week (prevent concurrent publishes).
  - compute aggregates efficiently: prefer array-accumulation in PHP or SQL lateral with generate_series per slot (Postgres) in PG env. For SQLite/CI, implement computation in PHP for tests.

Representación de slots (helper)
- helpers:
  - slot_index = (extract(hour from time)*60 + extract(minute))/5
  - slot_start_time = make_time(slot_index*5 minutes)

Performance y optimizaciones
- Use integers for slots to avoid timezone/range complexity; supports fast in-memory bitset.
- For large teams, use Redis bitmaps per team/date to increment bits for assigned slots; compute popcount for assigned_count quickly.
- Optionally create a materialized view `team_coverage_view` for PG with REFRESH MATERIALIZED VIEW CONCURRENTLY after publish.
- Indexes: on `shift_activities(start_slot, end_slot)`, `coverage_requirements(team_id, date, slot_index)`, `coverage_snapshots(team_id,date,slot_index)`.

Edge cases y reglas de negocio
- Shifts crossing midnight: business rule says 8h within same day; if cross-midnight required, model must support `end_date` or split into two `shifts`.
- Partial day permissions/vacations: create `shift_activities` with activity_type=VACATION/LEAVE that reduces assigned_count for working slots.
- Overlaps: validate in Action that for a given shift, `shift_activities` do not overlap; enforce slot-level non-overlap.
- Swaps: on approve, recompute only affected team's slots (delta update), use transaction + advisory lock.

Testing strategy
- Unit tests for:
  - slot_index calculation.
  - activity overlap detection.
  - coverage aggregator: small seeded datasets for teams with known expected deficits.
- Feature tests:
  - Publish success when coverage OK.
  - Publish failure with deficit report when coverage insufficient.
  - Swap approval blocked when causes deficit (unless force_approve + admin).
- CI:
  - Keep SQLite-friendly code paths (pure-PHP aggregation) for unit tests; create PG-specific integration tests in separate pipeline stage to validate materialized views / SQL-level methods.

Trade-offs
- Usar slots integer (5-min) vs. tstzrange+EXCLUDE:
  - Slots integer: +mucho más simple y portable (SQLite OK), +fast aggregation; -less semantic rangeness; -needs mapping logic.
  - tstzrange + EXCLUDE: +native overlap prevention in PG; -PG-only, breaks SQLite CI and complicates portability.
- Persisting `coverage_snapshots`:
  - +Fast reads for UI and reporting; -extra storage and need to refresh on every publish/change.
  - Option: compute on-demand for small teams; snapshot for published schedules only.

Seguridad, concurrencia y resiliencia
- Always wrap publish, swap-approve, and bulk-assign in DB::transaction().
- Use PostgreSQL advisory locks per (team_id, date) to prevent concurrent publishes/approvals.
- Validate presence of `coverage_requirements` config per team; otherwise use team-default setting.
- Audit: emit Event `WeeklySchedulePublished` for notification listeners and snapshot creation.
