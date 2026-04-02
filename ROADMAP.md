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
  - [x] UC-EMP-03.1: Distintos scopes `own` vs `others` y `force_delete` solo para roles de alto privilegio.
  - [x] UC-EMP-03.2: Policy `effectivePermissions` con role hierarchy y administrator override.
- [x] UC-EMP-04: Importador masivo CSV. **[DEUDA TÉCNICA: Refactorizado a Chunked/Queueable para evitar memory leaks]**.
  - [x] UC-EMP-04.1: Acción `ImportEmployeesAction` con `LazyCollection::chunk(1000)` + `DB::transaction` por chunk.
  - [x] UC-EMP-04.2: Job/Batch en queue y reporte de filas rechazadas / inválidas.
  - [x] UC-EMP-04.3: Manejo de duplicados, relaciones inexistentes (`position`, `team`) y rollback selectivo.

---

## 🔵 FASE 3 / SPRINT 3: Scheduling (Core Técnico) (En Progreso 🟡)

> *Planificación, validación y publicación del horario como fuente de verdad operativa.*

### Objetivo

Implementar el ciclo completo de horario (`draft` → `published` → `modified/cancelled`) con validaciones de cobertura por franja de 5 minutos y publicación segura.

### Backlog ejecutable (Sprint 3) — estado verificado (2026-04-02)

> Verificación real:
> - `runTests` sobre Scheduling: **8 passed / 0 failed**
> - `php artisan route:list --name=scheduling`: existen `scheduling.assign_grid` y `scheduling.break_templates.create`

- [x] UC-SCH-01: Completar modelos base `Schedule`, `BreakTemplate`, `Shift` y estados operativos.
  - [x] `Schedule`, `BreakTemplate` y `Shift` existen y están alineados con la estrategia actual `bigint`.
  - [x] Estados operativos de `Shift` disponibles mediante `ShiftStatus` (`draft`, `published`, `modified`, `cancelled`).
- [ ] UC-SCH-02: Cerrar CRUD + Actions atómicas para plantillas y asignaciones iniciales.
  - [x] Asignaciones iniciales implementadas con `AssignEmployeeScheduleAction`.
  - [x] `CreateBreakTemplateAction`, `CreateBreakTemplateDTO` y componente Livewire `CreateBreakTemplate` ya están implementados.
- [x] UC-SCH-03: `ScheduleValidationService` (solapamientos, contigüidad y reglas base).
- [x] UC-WPL-01: `WeeklySchedule` y `WeeklyScheduleAssignment`.
- [x] UC-WPL-02: Constraints e índices para planning semanal (`unique`, `exclude overlaps` en PG).
- [x] UC-WPL-03: `AssignEmployeeScheduleAction` (bulk assign con validación).
- [ ] UC-WPL-04: Integración final de la UI Livewire de asignación masiva.
  - [x] `AssignGrid` y `preflight` existen.
  - [ ] Falta la ruta real `scheduling.weekly_schedules.show` para cerrar el flujo post-aplicación.
- [x] UC-WPL-05: RFC técnico final en `docs/technical/10_RFC_WPL-03-04.md`.

### Nuevas funcionalidades a ejecutar

- [ ] UC-SCH-04: `PublishWeeklyScheduleAction` con validación de cobertura mínima por `team/date/slot` y bloqueo por déficit.
- [ ] UC-SCH-05: Detalle de franjas deficitarias en respuesta de publicación (`slot_index`, hora, `assigned_count`, `required_min`).
- [ ] UC-SCH-06: Reglas de actividades por turno (`ShiftActivity`): no solapamiento entre actividades ni con break/lunch.
- [ ] UC-SCH-07: `GetMyScheduleAction` + vista "Mi Horario" en tiempo real (agente).
- [ ] UC-SCH-08: Notificación de horario publicado (email + push + in-app).
- [ ] UC-SCH-09: Feature tests de publicación exitosa y bloqueo por déficit.

### DoD de la fase

- Publicación siempre en `DB::transaction()` y sin N+1 (`with()` obligatorio).
- Cobertura validada por slots `0..287` (5 minutos).
- Respuesta funcional con detalle accionable para coordinador.
- Tests unitarios + feature para validaciones de cobertura y actividades.

---

## 🟣 FASE 4 / SPRINT 4: Workflows (Permisos y Swaps)

> *Flujos operativos de solicitud/respuesta/aprobación con trazabilidad total.*

### Objetivo

Implementar permisos trimestrales y swaps (día/período/intraday) con reglas de cobertura y control de estados.

### Backlog ejecutable (Sprint 4)

- [ ] UC-LRQ-01: Ajustar `LeaveRequest` para incluir regla de permiso trimestral (`8h/trimestre`, no acumulable).
- [ ] UC-LRQ-02: `GetQuarterlyPermissionBalanceAction` por agente/trimestre.
- [ ] UC-LRQ-03: `CreateLeaveRequestAction` validando saldo trimestral + cobertura.
- [ ] UC-LRQ-04: `Approve/RejectLeaveRequestAction` con auditoría y comentario obligatorio.
- [ ] UC-LRQ-05: Bandeja Livewire para coordinador (filtros por equipo, estado, rango de fechas, acciones en lote).

- [ ] UC-SWP-01: Modelo/flujo `ShiftSwapRequest` con estados: `PENDING`, `ACCEPTED`, `COORDINATOR_REVIEW`, `APPROVED`, `REJECTED`, `CANCELLED`.
- [ ] UC-SWP-02: `CreateShiftSwapRequestAction` (`SINGLE_DAY` y `PERIOD`) con validación de compatibilidad.
- [ ] UC-SWP-03: `RespondToShiftSwapAction` (usuario objetivo acepta/rechaza).
- [ ] UC-SWP-04: `ApproveShiftSwapAction` con validación de cobertura y actualización automática de ambos horarios.
- [ ] UC-SWP-05: `ForceApproveSwapAction` (solo Administrador/Supervisor) con nota obligatoria.
- [ ] UC-SWP-06: Cancelación automática de swaps `PERIOD` si aparece excepción intermedia.
- [ ] UC-SWP-07: `Swap intraday` con expiración automática de respuesta en 15 minutos.

### DoD de la fase

- Todos los Actions transaccionales y protegidos por Policy.
- Trazabilidad completa en `AuditLog` (solicita/responde/aprueba/rechaza/fuerza).
- Reglas de cobertura aplicadas en aprobación de permisos y swaps.
- Feature tests end-to-end de permisos y swaps.

---

## 🟠 FASE 5 / SPRINT 5: Operations (Intradía e Incidencias)

> *Operación en tiempo real: excepciones, justificaciones y alertamiento.*

### Objetivo

Registrar y reconciliar eventos intradía (tardanza, ausencia, cita médica, permiso no planificado) actualizando el horario en tiempo real.

### Backlog ejecutable (Sprint 5)

- [ ] UC-INP-01: `AssignIntradayActivityAction` para actividades operativas (`MEETING`, `TRAINING`, `PROJECT`, etc.) sin solapamiento.
- [ ] UC-INP-02: Timeline "Mi Día" (Livewire + FluxUI) con vista por slot.
- [ ] UC-INP-03: Reasignación intradía con revalidación de cobertura en caliente.

- [ ] UC-ATT-01: `RecordShiftExceptionAction` para `TARDINESS`, `ABSENCE`, `MEDICAL_APPOINTMENT`, `QUARTERLY_PERMISSION`, `OTHER`.
- [ ] UC-ATT-02: `JustifyShiftExceptionAction` con ventana configurable (24-48h).
- [ ] UC-ATT-03: Job de auto-marcado de incidencias injustificadas al vencer la ventana.
- [ ] UC-ATT-04: Alerta a supervisor cuando un agente supera `N` incidencias injustificadas en el mes.
- [ ] UC-ATT-05: Actualización en tiempo real del horario/estado del agente tras registrar excepción.

### DoD de la fase

- Eventos intradía visibles en tiempo real para coordinador y agente.
- Justificación con SLA configurable y fallback automático.
- Alertas operativas disparadas por reglas mensuales.
- Pruebas de integración para flujo registrar → justificar → alertar.

---

## 📊 FASE 6 / SPRINT 6: Reporting & Analytics

> *Explotación operativa: cobertura, cumplimiento y salud del proceso.*

### Backlog ejecutable (Sprint 6)

- [ ] UC-REP-01: `CoverageReportService` por equipo/día/franja con exportación CSV/Excel.
- [ ] UC-REP-02: `ScheduleComplianceReportService` (adherencia plan vs ejecutado).
- [ ] UC-REP-03: `QuarterlyPermissionBalanceReportService` (consumo y saldos por trimestre).
- [ ] UC-REP-04: `SwapLifecycleReportService` (tiempos de respuesta, aprobaciones/rechazos/expiraciones).
- [ ] UC-REP-05: `UnjustifiedIncidentsReportService` (acumulado mensual por agente/equipo).
- [ ] UC-DBR-01: Dashboard Livewire con KPIs: cobertura, déficit por franja, ausentismo, swaps, permisos trimestrales.
- [ ] UC-DBR-02: Widget de alertas tempranas (`cobertura en riesgo`, `permiso ≥80% consumido`, `SLA swaps intraday`).

### DoD de la fase

- Consultas optimizadas (`with()`, índices compuestos, sin N+1).
- Exportables funcionales y filtros por rol/equipo/fecha.
- Métricas clave disponibles para Supervisor y Administración.

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
