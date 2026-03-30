# 🗺️ ROADMAP DE DESARROLLO — WFM Call Center CSS (v2.0)

**Proyecto:** HorariosWFM (Monolito Modular)
**Estado:** Actualizado a Marzo 2026
**Arquitectura:** Laravel 12 + Livewire 3 + FluxUI + PostgreSQL
**Uso para IA:** Copiar la referencia de la tarea (ej. `UC-LRQ-01`) y pasarla al agente junto con el prompt de `new-task`.

---

## 📊 MÉTRICAS Y ESTADO ACTUAL (Marzo 2026)

* **Progreso General:** ~60% del sistema funcional (Núcleo base operativo).
* **Testing:** Suite base completa (31 tests pasando, 72 assertions). CI/CD configurado.
* **UI/UX:** Integración global de FluxUI y Heroicons completada. Formularios reactivos.
* **Arquitectura:** Patrón `ModuleServiceProvider` estandarizado, Actions, DTOs, transacciones DB.

### ⚠️ Deuda Técnica Global (Obligatorio para nuevas tareas IA)
- [ ] **GLO-01 (ULIDs):** Todo nuevo modelo debe heredar de un `BaseModel` que use **ULIDs** como Primary Key, no IDs autoincrementales.
- [ ] **GLO-02 (Performance):** Mantener `preventLazyLoading` activo. Toda consulta nueva debe usar `with()`.
- [ ] **GLO-03 (Testing):** Todo nuevo `UC-XXX` debe incluir su respectivo Feature Test en Pest/PHPUnit.

---

## 🟢 FASE 1 / SPRINTS 0-1: Foundation & Organization (Completado ✅)

> *Base sólida, permisos, auditoría y estructura organizativa. Integración de FluxUI.*

### Módulo: Core & Organization & Geography
- [x] UC-COR-01: Autenticación Fortify/Sanctum, Login y Rate Limiting.
- [x] UC-COR-02: CRUD de Usuarios y SoftDeletes.
- [x] UC-COR-03: RBAC (Spatie Permissions) jerárquico + Caché de permisos.
- [x] UC-ORG-01: Estructura organizacional completa (Directorates → Teams).
- [x] UC-GEO-01: Catálogo geográfico (LocationModule).
- [ ] NA: Forzar cambio de contraseña en primer login (Implementar en Fase 2).

### Módulo: Audit & Cache
- [x] UC-AUD-01: Modelo `AuditLog` y Trait `Auditable` implementado.
- [x] UC-AUD-02: Componente UI Livewire (FluxUI) para visor/búsqueda de logs operativos.
  - [x] UC-AUD-02.1: Listado paginado de `audit_logs` con filtros (usuario, entidad, acción, rango de fechas).
  - [x] UC-AUD-02.2: Acción de exportar CSV/JSON para resultados filtrados.
  - [x] UC-AUD-02.3: Políticas de acceso `audit.view` y `audit.export` (Spatie + Gate).
  - [x] UC-AUD-02.4: Test de integración Pest para UI y API de logs.
- [x] UC-AUD-03: Command de retención/limpieza de logs (`audit:prune --days=...`).
- [x] UC-CAC-01: Caché inteligente habilitado en config e invalidación en Observers.

---

## 🟢 FASE 2 / SPRINT 2: Employees (Completado ✅)

> *Núcleo del negocio. Gestión de personal y jerarquías operativas.*

### Módulo: Employees
- [x] UC-EMP-01: Modelos `Employee`, `EmploymentStatus` con jerarquía (`parent_id`).
  - [x] UC-EMP-01.1: Relaciones completas con `Team`, `Department`, `Position` y cascada de desactivación por status.
  - [x] UC-EMP-01.2: Índices de DB `employee(team_id, status_id, deleted_at)` y `status(parent_id)`.
- [x] UC-EMP-02: Interfaz Livewire reactiva con filtros avanzados (búsqueda, dpto, cargo).
  - [x] UC-EMP-02.1: Paginación server-side con `with('team','position','status')` + anti N+1 test.
  - [x] UC-EMP-02.2: Export CSV/Excel desde UI (selected/all) y parámetros de rango de fechas.
- [x] UC-EMP-03: Policies con scope por `team_id` y permisos granulares.
  - [ ] UC-EMP-03.1: Distintos scopes `own` vs `others` y `force_delete` solo para roles de alto privilegio.
  - [ ] UC-EMP-03.2: Policy `effectivePermissions` con role hierarchy y administrator override.
- [~] UC-EMP-04: Importador masivo CSV. **[DEUDA TÉCNICA: Refactorizar a Chunked/Queueable para evitar memory leaks]**.
  - [ ] UC-EMP-04.1: Acción `ImportEmployeesAction` con `LazyCollection::chunk(1000)` + `DB::transaction` por chunk.
  - [ ] UC-EMP-04.2: Job/Batch en queue y reporte de filas rechazadas / inválidas.
  - [ ] UC-EMP-04.3: Manejo de duplicados, relaciones inexistentes (`position`, `team`) y rollback selectivo.

---

## 🔵 FASE 3 / SPRINT 3: Scheduling (Core Técnico) (En Progreso 🟡)

> *Módulo más complejo. Riesgo alto de consultas N+1 y solapamientos.*

### Módulo: Schedule (Catálogos base)
-[~] UC-SCH-01: Modelos base `Schedule` y `BreakTemplate` con ULIDs.
- [ ] UC-SCH-02: `CreateBreakTemplateAction` (plantillas de descanso por equipo).
- [ ] UC-SCH-03: `ScheduleValidationService` (validación estricta `start < end` y no-solapamiento).

### Módulo: WeeklyPlanning (Asignaciones)
- [ ] UC-WPL-01: Modelos `WeeklySchedule` y `WeeklyScheduleAssignment`.
- [ ] UC-WPL-02: Constraints DB: `unique (week_start_date)` y `unique (weekly_schedule_id, employee_id)`.
- [ ] UC-WPL-03: `AssignEmployeeScheduleAction` (Uso obligatorio de Bulk Insert, NO loops).
- [ ] UC-WPL-04: Componente Livewire UI: Grid de asignación semanal optimizado.

---

## 🟣 FASE 4 / SPRINT 4: Workflows (Flujo Operativo Real)

> *Desacoplado en módulos independientes por principios SOLID.*

### Módulo: LeaveRequest (Permisos)
- [ ] UC-LRQ-01: Modelos `LeaveRequest` y `LeaveRequestApproval`.
- [ ] UC-LRQ-02: `CreateLeaveRequestAction` (Validación contra solapamientos y duplicados).
- [ ] UC-LRQ-03: `ApproveLeaveRequestAction` y `RejectLeaveRequestAction` con justificación.
- [ ] UC-LRQ-04: Componente Livewire de bandeja de entrada para Coordinadores (Scope por `team_id`).

### Módulo: ShiftSwap (Cambio de Turnos)
- [ ] UC-SWP-01: Modelo `ShiftSwapRequest`.
- [ ] UC-SWP-02: `CreateShiftSwapRequestAction` (solicitud) y `RespondToShiftSwapAction` (aceptación de contraparte).
- [ ] UC-SWP-03: `ApproveShiftSwapAction` (Validación de compatibilidad de horarios por Coordinador).

---

## 🟠 FASE 5 / SPRINT 5: Operations (Intradía e Incidencias)

> *Control en tiempo real del piso de operaciones.*

### Módulo: IntradayPlanning
- [ ] UC-INP-01: Modelos `IntradayActivity` y `IntradayActivityAssignment`.
- [ ] UC-INP-02: `AssignIntradayActivityAction` (Validación de cupos máximos y conflicto con turno principal).
- [ ] UC-INP-03: Componente FluxUI: Timeline intradía (MyDay).

### Módulo: Attendance
- [ ] UC-ATT-01: Modelos `IncidentType` y `AttendanceIncident`.
- [ ] UC-ATT-02: `RecordAttendanceIncidentAction` (Tardanzas, ausencias).
- [ ] UC-ATT-03: Componente UI para registro y justificación cruzada con `LeaveRequest`.

---

## 📊 FASE 6 / SPRINT 6: Reporting & Analytics

### Módulo: Reports & Dashboard
- [ ] UC-REP-01: `AttendanceReportService` y exportación a Excel/CSV.
- [ ] UC-REP-02: `ScheduleComplianceReportService` (Adherencia al horario).
- [ ] UC-DBR-01: Dashboard Livewire con KPIs (Ausentismo, Cobertura) integrando Recharts/Chart.js.

---

## 🌐 FASE 7 / SPRINT 7: Engagement (Ampliación v2.0)

> *Funcionalidades de valor agregado para retención y servicio externo.*

- [x] UC-COM-01: Comunicaciones internas (`NewsArticle`, `NewsCategory`) - **Implementado parcialmente**.
- [ ] UC-SUR-01: Encuestas internas y clima laboral (`Surveys`).
- [ ] UC-CIT-01: Gestión de Ciudadanos y registro de llamadas entrantes (`Citizens`).

---

## 🛠️ INSTRUCCIONES DE USO PARA EL AGENTE DE IA

1. **Lee el contexto:** Antes de codificar, analiza este roadmap y el prompt principal.
2. **Usa el Código UC:** El usuario te dará un código (Ej. `UC-WPL-03`).
3. **Aplica Deuda Técnica (GLO):** Automáticamente asegura que tu código cumpla con las reglas GLO-01, GLO-02 y GLO-03 (ULIDs, no N+1, y Tests).
4. **Respeta Git Flow:** Genera los comandos de rama, los commits atómicos y el código listo para producción.
