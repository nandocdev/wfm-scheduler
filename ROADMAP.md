# Roadmap (Monolito Modular)

## Supuestos

* Sprint = 1 semana
* Objetivo: sistema usable desde Sprint 4
* Prioridad: **flujo real → no CRUDs sueltos**
* Nomeclatura de seguimiento:
  * [ ] = pendiente
  * [x] = hecho
  * [~] = en progreso

---

# 🧱 Sprint 0 — Foundation (CoreModule)

> Sin esto, todo lo demás es deuda técnica

### CoreModule

* [x] Configurar Spatie Permission (roles + permisos base)
* [x] Seeder inicial (roles jerárquicos + permisos mínimos)
* [x] Cache de permisos habilitado
* [x] Middleware de autorización global
* [x] Configurar `preventLazyLoading` — Pendiente: agregar en AppServiceProvider para evitar N+1 queries
* [x] Auditoría base (`audit_logs`) — Pendiente: implementar modelo y listeners para trazabilidad
* [ ] BaseModel con:
  * [ ] ULIDs / UUID — Pendiente: crear BaseModel con ULID primary key
  * [x] SoftDeletes — Implementado en User model
* [x] ServiceProvider del módulo

### Riesgos

* Sin cache → latencia en cada request — **RESUELTO**: cache habilitado en config/permission.php
* Sin auditoría → imposible trazabilidad (requisito crítico) — **RESUELTO**: modelo AuditLog y trait Auditable implementados

---

# 🏢 Sprint 1 — Organization + Location (estructura)

> Base estructural. Sin esto no existe jerarquía.

### OrganizationModule

* [x] Models: Directorate, Department, Position, Team
* [x] Migraciones + índices únicos compuestos
* [x] Policies básicas (`viewAny`)
* [x] DirectorateController, DepartmentController, PositionController, TeamController
* [x] ModuleServiceProvider + registro en bootstrap
* [x] Routes RESTful
* [x] Observers con cache invalidation
* [ ] Actions:

  * [ ] CreateDepartmentAction
  * [ ] CreateTeamAction
* [ ] Livewire:
  * [ ] ListDepartments
  * [ ] CreateDepartment

### LocationModule

* [ ] Models: Province, District, Township
* [ ] Seeder geográfico (Panamá completo)
* [ ] Relaciones jerárquicas optimizadas
* [ ] Indexación FK

### Riesgos

* Jerarquía mal definida → rompe permisos después
* Sin índices → joins lentos en Employees

---

# 👥 Sprint 2 — Employees (núcleo del negocio)

> Entidad central del sistema

### EmployeesModule

* [ ] Models:

  * [ ] Employee
  * [ ] EmploymentStatus
* [ ] Relaciones:

  * [ ] user_id
  * [ ] team_id
  * [ ] parent_id (jerarquía)
* [ ] Constraints:

  * [ ] `parent_id != id`
* [ ] Actions:

  * [ ] CreateEmployeeAction
  * [ ] UpdateEmployeeAction
* [ ] DTOs (readonly)
* [ ] Policies:

  * [ ] scope por `team_id`
* [ ] Livewire:

  * [ ] ListEmployees (con filtros)
  * [ ] CreateEmployee

### Extra crítico

* [ ] Importador CSV (chunked, queueable)

### Riesgos

* CSV sin chunking → memory leak
* Jerarquía rota → approvals fallan

---

# ⏱️ Sprint 3 — Scheduling (core técnico)

> Módulo más complejo

### SchedulingModule

* [ ] Models:

  * [ ] Schedule
  * [ ] WeeklySchedule
  * [ ] WeeklyScheduleAssignment
* [ ] Constraints:

  * [ ] unique (week_start_date)
  * [ ] unique (weekly_schedule_id, employee_id)
* [ ] Actions:

  * [ ] CreateWeeklyScheduleAction
  * [ ] AssignEmployeeScheduleAction
* [ ] Validaciones:

  * [ ] solapamiento de horarios
* [ ] Livewire:

  * [ ] CreateWeeklySchedule
  * [ ] AssignSchedules (grid)

### Performance

* [ ] Bulk insert (NO loops)
* [ ] Index por `employee_id + week`

### Riesgos

* N+1 en asignaciones → muerte
* Sin validación de solapamiento → datos corruptos

---

# 🔄 Sprint 4 — Workflows (flujo real)

> Aquí el sistema empieza a servir

### WorkflowsModule

#### Leave (Permisos)

* [ ] Models:

  * [ ] LeaveRequest
  * [ ] LeaveRequestApproval
* [ ] Actions:

  * [ ] RequestLeaveAction
  * [ ] ApproveLeaveAction
  * [ ] RejectLeaveAction
* [ ] Events:

  * [ ] LeaveRequested
  * [ ] LeaveApproved
* [ ] Policies:

  * [ ] scope por `team_id`

#### ShiftSwap

* [ ] Models:

  * [ ] ShiftSwapRequest
* [ ] Actions:

  * [ ] RequestShiftSwapAction
  * [ ] AcceptShiftSwapAction
* [ ] Validaciones:

  * [ ] compatibilidad de horarios

### Livewire

* [ ] RequestLeave
* [ ] ApproveLeave
* [ ] RequestShiftSwap

### Riesgos

* Race condition en aprobaciones
* Sin transacciones → doble aprobación

---

# 📊 Sprint 5 — Operations (intradía + incidencias)

### OperationsModule

#### Intraday

* [ ] Models:

  * [ ] IntradayActivity
  * [ ] IntradayActivityAssignment
* [ ] Actions:

  * [ ] AssignIntradayActivityAction

#### Incidents

* [ ] Models:

  * [ ] IncidentType
  * [ ] AttendanceIncident
* [ ] Actions:

  * [ ] RegisterIncidentAction

### Livewire

* [ ] MyDay (timeline intradía)
* [ ] RegisterIncident

### Riesgos

* Queries por día sin índice → lentas
* Timeline mal modelado → UX rota

---

# 🛠️ Sprint 6 — Support (transversal)

### SupportModule

* [ ] Notifications (DB + broadcast)
* [ ] Audit viewer UI
* [ ] Configuración WFM
* [ ] Logs operativos

### Integraciones internas

* [ ] Listeners:

  * [ ] SendNotificationListener
  * [ ] AuditLogListener

### Riesgos

* Eventos sin cola → bloqueo request
* Notificaciones síncronas → latencia

---

# 🚀 Sprint 7 — Hardening (producción)

### Global

* [ ] Eager loading auditado
* [ ] Índices revisados (EXPLAIN ANALYZE)
* [ ] Cache:

  * [ ] permisos
  * [ ] catálogos
* [ ] Rate limiting (login, actions críticas)
* [ ] Jobs en cola (Redis recomendado)
* [ ] Backups

### Seguridad

* [ ] Policies 100% coverage
* [ ] Validación masiva de endpoints
* [ ] Sanitización inputs

### Riesgos

* Sin profiling → cuellos invisibles
* Sin colas → sistema no escala

---

# ⚠️ Orden correcto (no lo rompas)

```
Core
 → Organization + Location
   → Employees
     → Scheduling
       → Workflows
         → Operations
           → Support
```

Romper este orden = retrabajo garantizado.

---

# 📈 Avance Actual del Proyecto

**Fecha:** 24 de marzo de 2026
**Sprint Actual:** 0 (Foundation)
**Progreso:** 100% completado

### Estado de Sprints:
- **Sprint 0:** 8/8 tareas completadas
- **Sprint 1-7:** Pendientes

### Próximas Acciones:
- Completar elementos críticos de Sprint 0 (auditoría, preventLazyLoading)
- Iniciar Sprint 1 (Organization + Location)

### Métricas Funcionales:
- [x] Usuario puede iniciar sesión (implementado con Fortify)
- [ ] Usuario puede ver su equipo (pendiente: EmployeesModule)
- [ ] WFM puede crear horario (pendiente: SchedulingModule)
- [ ] Operador puede ver su horario (pendiente)
- [ ] Operador puede pedir permiso (pendiente: WorkflowsModule)
- [ ] Coordinador puede aprobar (pendiente)

El proyecto está en fase de foundation sólida, con base RBAC y UI administrativa funcional. Faltan módulos de negocio para alcanzar usabilidad real.

---

# Métrica real de progreso

No midas por “features hechas”, mide por:

* [ ] Usuario puede iniciar sesión
* [ ] Usuario puede ver su equipo
* [ ] WFM puede crear horario
* [ ] Operador puede ver su horario
* [ ] Operador puede pedir permiso
* [ ] Coordinador puede aprobar

Si eso no funciona → tu sistema no existe.
