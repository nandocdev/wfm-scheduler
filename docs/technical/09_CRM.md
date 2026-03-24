Análisis estratégico y técnico del centro de contactos de la Caja de Seguro Social: Optimización de servicios y arquitectura para la gestión dinámica de datos mediante un sistema CRM ciudadano
La Caja de Seguro Social (CSS) de la República de Panamá se encuentra inmersa en un proceso de transformación sin precedentes, motivado tanto por la presión demográfica como por la necesidad de una reingeniería administrativa que garantice la sostenibilidad del sistema de seguridad social. En este contexto, el Centro de Contactos no es simplemente una unidad de respuesta telefónica, sino el núcleo operativo de una estrategia omnicanal diseñada para cerrar la brecha entre la institución y sus más de tres millones de usuarios.1 La eficiencia de este centro impacta directamente en la percepción de calidad del servicio de salud y en la agilidad de los trámites de prestaciones económicas, elementos que constituyen los pilares del bienestar social en el país.
El presente reporte analiza de manera exhaustiva la configuración actual del Centro de Contactos, evaluando sus capacidades tecnológicas, su catálogo de servicios y los desafíos operativos identificados mediante estudios de satisfacción y análisis de flujo de procesos. Asimismo, se propone una hoja de ruta para la implementación de un sistema de Customer Relationship Management (CRM) —o más específicamente, un Citizen Relationship Management (CiRM)— que actúe como una capa de inteligencia sobre los sistemas existentes, permitiendo una gestión de datos dinámica, segura y centrada en el asegurado.3
Marco operativo y funcional del centro de contactos
El Centro de Contactos de la CSS opera bajo la Dirección Ejecutiva Nacional de Servicios al Asegurado (DENSA), una instancia encargada de velar por que la interacción con el usuario se rija por principios de mesura, tolerancia y calidad.5 La estructura funcional del centro ha evolucionado de un modelo de recepción de llamadas tradicional hacia una plataforma tecnológica que integra voz, mensajería instantánea y servicios web, facilitando el acceso a trámites que históricamente requerían la presencia física del asegurado en las instalaciones.1
Canales de atención y disponibilidad horaria
La estrategia de acceso se fundamenta en la diversificación de canales, permitiendo que diferentes segmentos de la población utilicen la herramienta que mejor se adapte a sus capacidades tecnológicas. La línea corta 199 sigue siendo el eje central para la población de mayor edad, mientras que las plataformas web y de mensajería como Telegram y WhatsApp ganan terreno entre los cotizantes activos.1

Canal de Comunicación
Identificador / Plataforma
Horario y Disponibilidad
Central Telefónica Nacional
Línea corta 199
Lunes a viernes de 6:00 a.m. a 5:00 p.m. 1
Mensajería WhatsApp
6997-2539
Lunes a viernes de 6:00 a.m. a 5:00 p.m. 1
Mensajería Telegram
Canal oficial CSS
Según disponibilidad de unidad ejecutora 8
Soporte Ciudadano
Línea 311 (AIG)
24 horas, 7 días a la semana 10
Portal Web de Citas
citas.css.gob.pa
24 horas para registro y solicitud 12
Gestión Digital
Mi Caja Digital
Acceso permanente 24/7 13

La limitación horaria de la atención humana hasta las 5:00 p.m. representa uno de los nudos críticos que la institución busca mitigar mediante la automatización. Durante la emergencia sanitaria, el centro implementó modalidades de teletrabajo para garantizar la continuidad del servicio, lo que demostró la flexibilidad de su arquitectura tecnológica basada en la nube.14 No obstante, la saturación en horas pico sigue siendo un desafío que afecta los tiempos de espera, los cuales pueden extenderse desde los 30 minutos hasta más de dos horas en casos críticos.7
Estructura jerárquica y departamentos técnicos
Para gestionar un volumen que supera las 280,000 interacciones mensuales en periodos de alta demanda, el centro se organiza en departamentos que segmentan la asistencia según la naturaleza del trámite.15 Esta segmentación es fundamental para la futura configuración de módulos en el sistema CRM, ya que define los flujos de trabajo y los niveles de autorización requeridos.
Departamento de Servicios para Salud: Responsable de la coordinación de agendas médicas, gestión de cupos de laboratorio y farmacia.6
Departamento de Asistencia de los Servicios al Asegurado: Enfocado en la orientación sobre trámites administrativos y validación de derechos.6
Ingeniería y Asistencia Técnica: Unidad encargada del soporte a plataformas como el Sistema de Ingresos y Prestaciones Económicas (SIPE) para empleadores.6
Control y Monitoreo: Encargado de la medición de la calidad y el seguimiento de las quejas registradas a través de herramientas como CIGESA.6
Descripción detallada de los servicios de salud y bienestar
El componente de salud representa la mayor carga operativa del Centro de Contactos, con un 36.63% de las interacciones totales dirigidas específicamente a la gestión de citas médicas.15 La transición hacia la digitalización busca no solo comodidad para el usuario, sino también una optimización del recurso médico al reducir el ausentismo y mejorar la distribución de la demanda en la red de policlínicas.
Gestión de citas médicas en medicina general y especialidades
El sistema actual permite solicitar citas de control y de primera vez a través de la web o el teléfono. El procedimiento web requiere que el usuario complete un registro exhaustivo que incluye número de cédula, fecha de nacimiento, números de contacto y correo electrónico.12 Una vez ingresada la solicitud, el sistema no otorga la cita de forma inmediata en todos los casos; en su lugar, genera un número de confirmación y el personal del Centro de Contactos realiza una llamada de retorno en un plazo de 48 a 72 horas para finalizar la asignación según la disponibilidad de la unidad ejecutora solicitada.12
Para las citas de especialidades, se exige que el paciente posea una referencia médica vigente. La digitalización de este proceso permite que el operador adjunte la referencia de forma electrónica, agilizando la validación por parte del médico especialista.18 Este flujo de información es un candidato ideal para la automatización mediante un CRM que integre el Sistema de Información de Salud (SIS), permitiendo que la referencia sea visible automáticamente para el operador sin intervención del asegurado.
Servicios de laboratorio clínico y farmacia
La red de laboratorios de la CSS ofrece un catálogo superior a las 100 pruebas clínicas. El Centro de Contactos actúa como un verificador de disponibilidad, informando al usuario en qué instalación puede realizarse estudios específicos como perfiles tiroideos, metabólicos o pruebas de coagulación.9

Categoría de Laboratorio
Pruebas Frecuentes
Modalidad de Cita
Hematología
Hemograma completo, plaquetas, coagulación 9
Demanda espontánea o cita previa
Química Clínica
Glucosa, creatinina, nitrógeno de urea 9
Ayuno requerido, validación web
Endocrinología
TSH, T3, T4 libre, perfil lipídico 9
Cita coordinada por el 199
Especiales
Pruebas de embarazo, urinálisis, heces 9
Entrega inmediata en policlínicas

En el ámbito farmacéutico, el Centro de Contactos ha incursionado en servicios de consulta de disponibilidad de medicamentos. Durante periodos de crisis, se han habilitado líneas para la solicitud de medicamentos a domicilio para pacientes crónicos y mayores de 65 años, una funcionalidad que requiere una base de datos georreferenciada para la logística de entrega.14
Validación del derecho a la atención
La validación del derecho es el mecanismo de control que asegura que los servicios se presten a contribuyentes vigentes o sus beneficiarios legales. El Centro de Contactos orienta al usuario sobre cómo obtener su ficha digital o talonario, documentos esenciales para la atención médica.19 Este proceso implica la verificación del historial de cotizaciones y la vigencia del trabajador en las planillas del empleador. La integración de esta validación en el CRM eliminaría la necesidad de que el usuario presente documentos físicos, ya que el sistema podría realizar una consulta en tiempo real a la base de datos de ingresos de la institución.19
Servicios de ingresos y prestaciones económicas
El segundo gran pilar del Centro de Contactos es la asistencia en trámites económicos y de afiliación, los cuales representan una complejidad administrativa superior debido a las implicaciones legales y financieras involucradas.
El sistema SIPE y la gestión del empleador
El Sistema de Ingresos y Prestaciones Económicas (SIPE) es la herramienta web que utilizan las empresas para gestionar sus obligaciones con la CSS. El Centro de Contactos brinda soporte en la inscripción de empleadores, la declaración de planillas y la obtención de la firma digital, un requisito indispensable para la validez legal de las transacciones electrónicas.22

Requisito para Inscripción SIPE
Documentación Necesaria
Observación Técnica
Identificación Legal
Pacto Social y reformas 22
Debe estar registrado en el Registro Público
Representación
Cédula del Representante Legal 22
Se requiere firma digital vinculada
Operatividad
Aviso de Operación o Registro Comercial 22
Define la actividad de riesgo profesional
Localización
Recibo de servicios públicos y croquis 22
Para inspecciones de campo

El soporte del Centro de Contactos en este área es crítico para la recaudación. Errores en la generación de comprobantes de pago o en la carga de archivos CSV para planillas masivas pueden derivar en morosidad involuntaria, afectando la paz y salvo de la empresa y, consecuentemente, el derecho de atención de sus empleados.22
Prestaciones a largo plazo: Pensiones y jubilaciones
La CSS gestiona diversos tipos de pensiones que requieren una validación exhaustiva de cuotas y vínculos familiares. El Centro de Contactos guía a los solicitantes a través de las plataformas digitales para el envío de formularios y documentos escaneados, buscando reducir los tiempos de trámite que históricamente han sido objeto de quejas.25
Pensión por Vejez: Requiere la verificación de la edad (57 años mujeres, 62 años hombres) y la densidad de cuotas mínima según la ley vigente.27
Pensión por Sobreviviente: Se origina tras el fallecimiento de un asegurado. El centro detalla la lista de documentos para esposas, hijos menores de edad o inválidos, y compañeros(as) de unión libre, incluyendo certificados de matrimonio y declaraciones de extrajuicio.29
Subsidios por Maternidad y Riesgos Profesionales: Trámites de corto plazo que requieren la validación inmediata del cese de labores y la condición médica.21
Para los jubilados y pensionados, el centro también gestiona consultas sobre el pago de reembolsos por lentes y prótesis dentales. El beneficio de lentes, por ejemplo, permite un reembolso de hasta el 50% de un valor máximo de B/. 125.00 cada dos años, siempre que se presente la receta original de un oftalmólogo u optómetra.31
Impacto de la Ley 462 de 2025 en la arquitectura de atención
La reforma de la Ley Orgánica de la CSS introducida en 2025 ha reconfigurado el panorama de la seguridad social en Panamá, imponiendo nuevos retos informativos para el Centro de Contactos. La creación del Nuevo Sistema Único de Capitalización Solidaria y el aumento escalonado de las cuotas patronales son temas que generan una alta demanda de aclaraciones por parte de la ciudadanía.27
Evolución de las tasas de cotización y capitalización
A partir de abril de 2025, el aporte patronal inició un incremento progresivo que culminará en 2029. Este cambio debe estar perfectamente reflejado en el sistema SIPE y ser comprendido por los agentes del Centro de Contactos para orientar a las empresas sobre sus nuevos avisos de cobro.27

Periodo de Vigencia
Tasa de Aporte Patronal
Incremento Porcentual
Hasta marzo 2025
12.25% (Base previa)
-
Abril 2025 - Febrero 2027
13.25% 27
+1.00%
Marzo 2027 - Febrero 2029
14.25% 27
+1.00%
Marzo 2029 en adelante
15.25% 27
+1.00%

La reforma también introduce el "Observatorio del Asegurado", una entidad de vigilancia que requiere que el Centro de Contactos sea más transparente en la gestión de datos.28 Además, herramientas como "Mi Retiro Seguro" permiten ahora que el asegurado consulte su historial de aportes y planifique su jubilación, una funcionalidad que ha atraído a más de 734,000 usuarios y que requiere soporte técnico constante por parte del centro.33
Análisis de satisfacción y diagnóstico de nudos críticos
La optimización de la atención no puede realizarse sin un diagnóstico basado en la experiencia real del usuario. Estudios de satisfacción realizados en las unidades ejecutoras del área metropolitana e interior del país han revelado disparidades significativas en los tiempos de respuesta y la eficacia de la resolución de problemas.7
Tiempos de espera y eficiencia del canal telefónico
A pesar del esfuerzo por digitalizar las citas, un porcentaje considerable de la población sigue prefiriendo el contacto telefónico. Sin embargo, la percepción de rapidez es baja: el 80% de los encuestados niega que la solicitud por llamada sea rápida.7

Tiempo de Llamada para Cita
Porcentaje de Usuarios
Interpretación del Servicio
30 minutos
29.2%
Servicio aceptable para alta demanda 7
45 minutos
25.0%
Umbral de insatisfacción leve 7
1 hora a 1 hora 30 min
16.6%
Falla en la capacidad de respuesta 7
Más de 2 horas
29.2%
Abandono de canal o frustración crítica 7

Estas cifras sugieren que la infraestructura actual está saturada o que el proceso de validación manual de datos durante la llamada es ineficiente. El hecho de que un 36.7% de los usuarios reporte que la cita no se agendó con el doctor solicitado indica también una falta de sincronización entre el sistema de agendas del centro y la realidad operativa de las policlínicas.7
Desafíos en el manejo de quejas y denuncias
El sistema de quejas de la CSS está integrado con el Centro de Atención Ciudadana 311 de la AIG. La institución ha logrado niveles de respuesta del 100% en la resolución de casos registrados, una métrica alentadora pero que a menudo oculta la complejidad del problema de fondo.16 Las quejas son utilizadas por la Dirección General como indicadores de gerencia para la toma de decisiones basadas en hechos, pero la recolección de estos datos aún se realiza de manera fragmentada entre correos electrónicos (transparencia@css.gob.pa), llamadas al 199 y reportes presenciales con oficiales de atención.11
Propuesta de optimización: Arquitectura de un CRM para la CSS
El objetivo fundamental de este estudio es proponer la creación de un sistema CRM (Customer Relationship Management) que unifique la visión del asegurado. Un CRM en salud y seguridad social permite centralizar datos clínicos, administrativos y de comunicación para transformar la relación institucional de un modelo reactivo a uno proactivo y personalizado.3
Requisitos funcionales y módulos del sistema
Para que el CRM permita gestionar los datos de forma fácil y dinámica, debe estructurarse en módulos específicos que respondan a las necesidades de la CSS.
Módulo de Identidad Ciudadana 360: Centralización de datos de identidad, historial laboral, núcleo familiar y estatus de derecho. Debe integrarse con el SIS y el SIPE para evitar duplicidad de registros.35
Gestor de Citas e Interacciones: Un motor de agendamiento que permita al operador ver la disponibilidad en tiempo real de todas las policlínicas y especialidades, con capacidad de enviar recordatorios automáticos por canales digitales para reducir la mora médica.35
Módulo de Gestión de Casos de Prestaciones: Seguimiento del flujo de trámites de pensión, desde la solicitud inicial hasta el primer pago. Debe incluir alertas para documentos faltantes y notificaciones automáticas al correo del usuario.38
Omnicanalidad Integrada: Unificación de llamadas (199), chats (WhatsApp/Telegram), correos electrónicos y formularios web en una sola consola de agente, permitiendo la trazabilidad completa de la experiencia del asegurado.37
Módulo de Analítica y Business Intelligence: Herramientas para medir KPI de rendimiento, detectar patrones de salud en la población y optimizar la asignación de recursos médicos basándose en la demanda predictiva.35
Interoperabilidad y ecosistema tecnológico
La implementación del CRM debe realizarse bajo el paraguas del Plan de Transformación Digital del Estado. Esto implica una integración profunda con la plataforma "Panamá Conecta" y el uso de la identidad digital única para facilitar el acceso de los ciudadanos.41
El CRM propuesto no debe ser un silo de datos adicional, sino una capa de servicios que se conecte mediante APIs a los sistemas base de la CSS:
SIS (Sistema de Información de Salud): Para datos clínicos y de citas.
SIPE (Ingresos): Para validación de derechos y cuotas.
SAFIRO (Finanzas): Para el estatus de pagos de prestaciones.
Esta integración corregiría la ineficiencia histórica de tener sistemas fragmentados, permitiendo que un operador del Centro de Contactos resuelva una consulta compleja sin necesidad de navegar por múltiples aplicaciones.43
Transformación digital y visión de futuro (2025-2030)
La CSS está sentando las bases para una nueva era marcada por la tecnología. Proyectos como la telemedicina y la cirugía robótica ya son una realidad que ha beneficiado a miles de panameños, reduciendo la mora quirúrgica en un 38.3%.33 El Centro de Contactos debe evolucionar para gestionar no solo citas físicas, sino también consultas virtuales y seguimiento postoperatorio remoto.
Inteligencia Artificial y automatización ética
En colaboración con la AIG y Microsoft, la institución planea incorporar inteligencia artificial para mejorar la ciberseguridad y automatizar respuestas a través de asistentes virtuales éticos.46 Esto permitiría que el 199 se reserve para casos que requieren intervención humana empática, mientras que las consultas de saldo de cuotas o confirmación de horarios de farmacia sean resueltas por bots inteligentes integrados al CRM.
Integración de los sistemas de salud (MINSA-CSS)
El proceso de integración gradual de los servicios de salud entre el Ministerio de Salud (Minsa) y la CSS, que comenzará en las provincias de Herrera y Los Santos, requiere una plataforma de gestión común.44 El CRM propuesto facilitará que el personal de ambas instituciones comparta información sobre pacientes, evite la duplicidad de exámenes de laboratorio y optimice el uso de los tomógrafos y otros equipos de alta complejidad disponibles en la red nacional.33
Conclusiones y recomendaciones estratégicas
La investigación exhaustiva sobre el Centro de Contactos de la Caja de Seguro Social revela una institución en transición que posee una infraestructura base sólida pero que requiere una modernización urgente en su capa de gestión de datos. La fragmentación de los sistemas actuales es el principal obstáculo para una atención al cliente óptima y dinámica.
Recomendaciones para la optimización inmediata
Implementación del CRM Ciudadano: Priorizar el desarrollo de un CRM que unifique SIS, SIPE y SAFIRO para ofrecer una visión 360 del asegurado al personal de contacto.4
Rediseño de la Experiencia del Usuario (UX): Simplificar los portales de citas para que grupos vulnerables, como los adultos mayores, puedan acceder a los servicios con validaciones biométricas o de identidad simplificadas.7
Fortalecimiento de la Omnicanalidad: Expandir la capacidad de respuesta en Telegram y WhatsApp, integrando estos canales al CRM para que las conversaciones tengan historial y trazabilidad legal.8
Capacitación Técnica y Humana: Mantener programas de actualización para los oficiales de atención (DENSA) sobre las nuevas disposiciones de la Ley 462 y el uso de las herramientas de IA que se integren al flujo de trabajo.49
Monitoreo Basado en Datos: Utilizar la analítica del CRM para identificar nudos críticos en tiempo real y ajustar las agendas médicas dinámicamente según la tasa de cancelación detectada.36
El Centro de Contactos, transformado en una central de gestión dinámica de datos, se convertirá en el motor que permitirá a la Caja de Seguro Social cumplir con su misión de brindar protección social con eficiencia, transparencia y calidez humana en la nueva era digital.2
Fuentes citadas
Centro de Contactos – Caja de Seguro Social, acceso: febrero 25, 2026, https://www.css.gob.pa/centro-de-contactos/
Cuentas Claras, Futuro Seguro Informe de Gestión 2024 - 2025 - YouTube, acceso: febrero 25, 2026, https://www.youtube.com/watch?v=fO4cXfvr7VM
CRM En Salud: Mejora La Atención Y Gestión De Pacientes, acceso: febrero 25, 2026, https://agenciarococrm.com/crm-en-salud/
CRM para Gobierno - CRM 2go, acceso: febrero 25, 2026, https://www.crm2go.net/crm-para-gobierno/
Atención al Asegurado: una labor cargada de mesura y tolerancia - CSS Noticias, acceso: febrero 25, 2026, https://prensa.css.gob.pa/2020/07/28/atencion-al-asegurado-una-labor-cargada-de-mesura-y-tolerancia/
Centro de contactos: en conexión permanente con el usuario - CSS Noticias, acceso: febrero 25, 2026, https://prensa.css.gob.pa/2021/11/08/centro-de-contactos-en-conexion-permanente-con-el-usuario/
Evaluación de la Percepción de los Usuarios sobre la Calidad de la Atención en la Solicitud de Citas en la Caja de Segur - revistas científicas - Universidad de Panamá, acceso: febrero 25, 2026, https://revistas.up.ac.pa/index.php/REICIT/article/download/3952/3334/6593
La CSS moderniza gestión de citas médicas mediante Telegram - Mi Diario, acceso: febrero 25, 2026, https://www.midiario.com/nacionales/la-css-moderniza-gestion-de-citas-medicas-mediante-telegram/
Cómo gestionar una cita o cupo en los laboratorios clínicos de la CSS, acceso: febrero 25, 2026, https://prensa.css.gob.pa/2022/05/04/conozca-sobre-los-cupos-de-laboratorios-css/
311 Panamá Reporta tu caso, queja, denuncia, consulta, acceso: febrero 25, 2026, https://311.gob.pa/
Denuncias – Transparencia - Panamá - CSS, acceso: febrero 25, 2026, https://transparencia.css.gob.pa/denuncias/
acceso: febrero 25, 2026, https://www.telemetro.com/nacionales/css-como-solicitar-una-cita-medica-internet-panama-n6045133
Mi Caja Digital CSS Panamá: Guía Completa para Usar la Plataforma en Línea 2025, acceso: febrero 25, 2026, https://destinopanama.com.pa/2025/08/mi-caja-digital-css-panama-guia-completa-para-usar-la-plataforma-en-linea-2025/
Caja de Seguro Social anuncia nueva línea del centro de contactos - Nacionales | Tvn Panamá, acceso: febrero 25, 2026, https://www.tvn-2.com/nacionales/caja-seguro-social-anuncia-contactos_1_1164333.html
“Cada persona y empresa debe hacerse responsable del efecto que desea causar” - CSS, acceso: febrero 25, 2026, https://w3.css.gob.pa/wp-content/uploads/2020/12/Presentacio%CC%81n-Mariejane-Waugh-28-05-2021.pdf
CSS implementa aplicativo para responder quejas en tiempo ..., acceso: febrero 25, 2026, https://prensa.css.gob.pa/2021/10/16/css-implementa-aplicativo-para-responder-quejas-en-tiempo-oportuno/
Citas en la Caja de Seguro Social se darán de manera digital | TVN Noticias - YouTube, acceso: febrero 25, 2026, https://www.youtube.com/watch?v=BNEG7CMdQa8
CSS pone a disposición moderna plataforma para el trámite de citas médicas, acceso: febrero 25, 2026, https://prensa.css.gob.pa/2021/12/01/css-pone-a-disposicion-moderna-plataforma-para-el-tramite-de-citas-medicas/
CSS, validación del derecho: ¿Qué es y cómo funciona este requisito para recibir atención médica? - Telemetro, acceso: febrero 25, 2026, https://www.telemetro.com/nacionales/css-validacion-del-derecho-que-es-y-como-funciona-este-requisito-recibir-atencion-medica-n6043283
Validación de derechos en la CSS: en qué consiste y quiénes deben hacerla - Telemetro, acceso: febrero 25, 2026, https://www.telemetro.com/nacionales/validacion-derechos-la-css-que-consiste-y-quienes-deben-hacerla-n6043714
Actualizan proceso de validación del derecho a los trabajadores en las fincas bananeras, acceso: febrero 25, 2026, https://www.youtube.com/watch?v=CNkvOvsxIHI
Qué es SIPE y Cómo Utilizarlo Paso a Paso, acceso: febrero 25, 2026, https://www.tiempoexacto.com/post/qu%C3%A9-es-sipe-y-c%C3%B3mo-utilizarlo-paso-a-paso
Contrato de Firma Digital del Sistema de Ingresos y Prestaciones Económicas (SIPE) - Información de Trámite - Panamá Digital, acceso: febrero 25, 2026, https://www.panamadigital.gob.pa/InformacionTramite/contrato-de-firma-digital-del-sistema-de-ingresos-y-prestaciones-economicas-sipe
CSS IMPLEMENTA FICHA Y PAZ Y SALVO DIGITAL - YouTube, acceso: febrero 25, 2026, https://www.youtube.com/watch?v=jt2aqPA5O4c
Conozca el paso para realizar solicitud de pensión vía web - CSS Noticias, acceso: febrero 25, 2026, https://prensa.css.gob.pa/2024/07/24/conozca-el-paso-a-paso-para-realizar-solicitud-de-pension-via-web/
Jubilados y pensionados de la CSS: Nuevos pasos para solicitar el pago de pensión, acceso: febrero 25, 2026, https://www.telemetro.com/nacionales/atencion-jubilados-y-pensionados-css-pasos-llenar-la-solicitud-el-pago-pension-panama-n6039311
Reforma al Seguro Social en Panamá 2025: Principales Aspectos de la Ley N.º 462, acceso: febrero 25, 2026, https://fmm.com.pa/es/reforma-al-seguro-social-en-panama-2025-principales-aspectos-de-la-ley-n-o-462/
Actualización sobre la reforma a la CSS – Panamá, marzo 2025 - Siuma Talent, acceso: febrero 25, 2026, https://siumatalent.com/actualizacion-sobre-la-reforma-a-la-css-panama-marzo-2025/
Pensión de Sobreviviente - Información de Trámite - Panamá Digital, acceso: febrero 25, 2026, https://www.panamadigital.gob.pa/InformacionTramite/pension-de-sobreviviente
Mi Caja Digital vuelve a estar activa, ¿cómo ingresar? - La Web de la Salud, acceso: febrero 25, 2026, https://lawebdelasalud.com/mi-caja-digital-vuelve-a-estar-activa-como-ingresar/
Beneficios de Lentes para Jubilados y Pensionados. - Información de Trámite - Panamá Digital, acceso: febrero 25, 2026, https://www.panamadigital.gob.pa/InformacionTramite/beneficios-de-lentes-para-jubilados-y-pensionados
Reformas a la Ley Orgánica de la Caja de Seguro Social en Panamá - Pluxee, acceso: febrero 25, 2026, https://www.pluxee.pa/blog/reforma-caja-de-seguro-social-2025/
Reformas y tecnología marcan una nueva era en la Caja de Seguro Social - CSS Noticias, acceso: febrero 25, 2026, https://prensa.css.gob.pa/2025/10/15/reformas-y-tecnologia-marcan-una-nueva-era-en-la-caja-de-seguro-social/
DEPARTAMENTO DE ATENCIÓN AL ASEGURADO-SALUD ACTIVIDADES REALIZADAS A - CSS, acceso: febrero 25, 2026, https://w3.css.gob.pa/wp-content/wdocs/Informacio%CC%81n%20para%20Site%20Atencio%CC%81n%20al%20Asegurado%20en%20la%20WEB%20II%20Trimestre%202019%20revisado.pdf
CRM en medicina: optimizando la gestión de pacientes y procesos clínicos - Evoltis, acceso: febrero 25, 2026, https://evoltis.com/crm-en-medicina/
CRM de atención médica: significado, funcionamiento y beneficios - Vtiger, acceso: febrero 25, 2026, https://www.vtiger.com/es/blog/healthcare-crm-meaning-how-it-works-and-benefits/
CRM para hospitales y clínicas: qué es y cómo debes elegir uno - HubSpot, acceso: febrero 25, 2026, https://www.hubspot.es/products/crm/healthcare
las 10 mejores soluciones CRM gubernamentales para servicios públicos eficientes - ClickUp, acceso: febrero 25, 2026, https://clickup.com/es-ES/blog/444701/gobierno-crm
Guía sobre los sistemas CRM para organizaciones sin ánimo de lucro y lista con las mejores CRM - Zendesk, acceso: febrero 25, 2026, https://www.zendesk.es/sell/crm/nonprofit/
Página 4 - Software para call center. Opciones, opiniones y precios - Capterra Panamá, acceso: febrero 25, 2026, https://www.capterra.com.pa/directory/30007/call-center/software?page=4
Impulsan la transformación digital de Panamá con plataforma gubernamental - IT NOW, acceso: febrero 25, 2026, https://www.itnow.connectab2b.com/post/impulsan-la-transformacion-digital-de-panama-con-plataforma-gubernamental
[febrero 6 , 2026] Innovación, ciberseguridad e interoperabilidad centran el debate en GovTech 2.0, acceso: febrero 25, 2026, https://aig.gob.pa/innovacion-ciberseguridad-e-interoperabilidad-centran-el-debate-en-govtech-2-0/
CSS da primeros pasos para integrar sus sistemas de información, acceso: febrero 25, 2026, https://prensa.css.gob.pa/2024/01/03/css-da-primeros-pasos-para-integrar-sus-sistemas-de-informacion/
Panamá da un paso adelante al integrar los servicios de salud - CSS Noticias, acceso: febrero 25, 2026, https://prensa.css.gob.pa/2025/12/02/panama-da-un-paso-adelante-al-integrar-los-servicios-de-salud/
CSS 2025: Avances, Retos y Compromisos con la Salud de Panamá - YouTube, acceso: febrero 25, 2026, https://www.youtube.com/watch?v=1PED5y106jw
Panamá fortalece la transformación digital del Estado con acuerdo entre la AIG y Microsoft, acceso: febrero 25, 2026, https://www.ecotvpanama.com/nacionales/panama-fortalece-la-transformacion-digital-del-estado-acuerdo-la-aig-y-microsoft-n6067488
Panamá avanza hacia la transformación digital del sector salud con estrategia nacional 2025-2030, acceso: febrero 25, 2026, https://aig.gob.pa/panama-avanza-hacia-la-transformacion-digital-del-sector-salud-con-estrategia-nacional-2025-2030/
El plan de integración Minsa-CSS en atención está trazado y tomará dos años | La Prensa Panamá, acceso: febrero 25, 2026, https://www.prensa.com/sociedad/el-plan-de-integracion-minsa-css-en-atencion-esta-trazado-y-tomara-dos-anos/
DENSA - CSS Noticias, acceso: febrero 25, 2026, https://prensa.css.gob.pa/category/densa/
DENSA transforma la atención: calidad y empatía como prioridad - CSS Noticias, acceso: febrero 25, 2026, https://prensa.css.gob.pa/2025/01/21/densa-transforma-la-atencion-calidad-y-empatia-como-prioridad/
DENSA impulsa la capacitación continua para mejorar la atención al asegurado - CSS Noticias, acceso: febrero 25, 2026, https://prensa.css.gob.pa/2025/11/18/densa-impulsa-la-capacitacion-continua-para-mejorar-la-atencion-al-asegurado/
