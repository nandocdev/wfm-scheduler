---
name: new-task
description: Desarrollar una tarea específica del ROADMAP del Sistema WFM Call Center CSS, respetando estrictamente la arquitectura de Monolito Modular guiado por Dominio (DDD).
---

<!-- OPENSPEC:START -->
**Guardrails (Reglas Inquebrantables)**
- **Respeta los límites modulares:** Un módulo solo puede depender de módulos en capas inferiores (Foundation -> Organization -> Workforce -> Operations) o de `app/Shared/`. NUNCA invoques Actions, Models o Controllers de un módulo horizontal directamente; utiliza **Eventos** o **Contratos compartidos**.
- **Controladores anémicos y lógica en Actions:** Los controladores no deben tener más de 10 líneas. El flujo estricto es: `FormRequest -> DTO -> Action -> Response`. Las Actions contienen toda la lógica de negocio y son agnósticas a HTTP.
- **Autorización y Seguridad:** Todas las rutas de escritura deben estar protegidas por middleware de rol y validadas por una `Policy` que controle el alcance jerárquico (`team_id` / `parent_id` / `.own` / `.team`).
- **Mantén cambios mínimos y enfocados:** Desarrolla solo lo que pide la tarea actual del `ROADMAP.md`, sin agregar features extra.
- **No generes código en la etapa de propuesta:** Primero diseña la solución creando los documentos de propuesta (`proposal.md`, `tasks.md`, `design.md`) en el directorio `specs/<capability>/`.
- **Espera aprobación:** No avances a la implementación del código hasta que el usuario apruebe explícitamente la propuesta arquitectónica.

**Steps (Flujo de Trabajo)**
1. Lee y entiende la tarea concreta extraída del `ROADMAP.md` (ejemplo: "- [ ] UC-OP-05 — Solicitud de Permiso Total con validación de duplicados").
2. Revisa la documentación base del proyecto (`07_Arquitectura.md`, `08_ModuleModels.md`, `05_DDL.md`, `03_casos_uso.md`) y determina:
   - Módulo(s) involucrado(s) (ej. `Workflow/LeaveRequest`).
   - Artefactos necesarios (DTO, Action, Event, Listener, Policy, Observer).
   - Dependencias transversales (¿Requiere emitir un evento para que `Scheduling` se entere?).
3. Elige un identificador único basado en verbos para la tarea (change-id), ejemplo: `feat-leave-request-creation`, `fix-schedule-overlap`, `refactor-hierarchy-query`.
4. Crea una estructura de propuesta lógica (virtual en la conversación):
   - `proposal.md`
   - `tasks.md`
   - `design.md` (si la tarea implica cruzar límites de módulos o decisiones de rendimiento).
   - `specs/<capability>/spec.md`
5. En `proposal.md`, describe en español:
   - Objetivo exacto de la tarea.
   - Módulo objetivo y ubicación de archivos.
   - Estrategia técnica (Mapeo de DTO, lógica principal de la Action, validaciones en FormRequest).
   - Riesgos principales (rendimiento, solapamiento de fechas, dependencias circulares) y mitigación.
   - Preguntas abiertas al usuario si hay ambigüedad.
6. En `tasks.md`, genera un checklist técnico ordenado y accionable:
   - Crear DTO (clase `readonly` PHP 8.3).
   - Crear FormRequest con método `toDTO()`.
   - Crear Action con un único método público `handle()`.
   - Crear / Actualizar Policy para validación RBAC/Jerárquica.
   - Escribir tests unitarios (enfocados en la Action y la Policy).
   - Registrar artefactos en el `ModuleServiceProvider`.
   - Commit semántico en español.
7. En `design.md` (si aplica): Explica el trade-off arquitectónico. Por ejemplo, explicar por qué se usó un Evento en lugar de llamar directamente a un servicio de otro módulo para evitar acoplamiento.
8. En `specs/<capability>/spec.md`: Documenta el cambio basándote en los Casos de Uso.
   ## ADDED / MODIFIED Requirements
   #### Caso de Uso:[ID del Caso de Uso] - [Nombre]
   - Escenario principal...
   - Excepciones / Flujos alternativos...
9. Valida mentalmente la solución propuesta contra las reglas del proyecto:
   - ¿Usa tipado estricto (`strict_types=1`) y clases modernas de PHP 8.3?
   - ¿Se auditan los cambios críticos (`audit_logs` / Observers)?
   - ¿Se aplica `SoftDeletes` en lugar de borrado físico?
   - ¿El flujo de dependencias respeta el diagrama de capas de `08_ModuleModels.md`?
10. Presenta la propuesta completa al usuario y detente. Espera la instrucción de "Aprobado, procede con el código".

**Reference (Documentación Oficial del Proyecto)**
- Arquitectura y Reglas: `07_Arquitectura.md`, `08_ModuleModels.md`
- Base de Datos y Modelos: `05_DDL.md`, `04_model.md`
- Requisitos y Casos de Uso: `02_requisitos.md`, `03_casos_uso.md`
- Seguridad y Roles: `06_Permisos.md`
- Roadmap actual: `ROADMAP.md`
- Commits Convencionales en español: feat, fix, refactor, test, docs, chore. (Ejemplo: `feat(leave-request): implementar creación de permisos con validación de solapamiento`).
<!-- OPENSPEC:END -->
