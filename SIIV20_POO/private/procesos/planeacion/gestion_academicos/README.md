# Gestión Académica - Documentación

## Estructura del Sistema

### Archivos Principales

#### Clases de Procesamiento
- `academico_mostrar.php` - Clase para mostrar y obtener datos académicos
- `academico_editar.php` - Clase para editar registros académicos
- `academico_eliminar.php` - Clase para eliminar registros académicos (completa y suave)
- `academico_registrar.php` - Clase para registrar nueva información académica

#### Procesadores AJAX
- `procesar_editar.php` - Procesa peticiones AJAX para editar información académica
- `procesar_eliminar.php` - Procesa peticiones AJAX para eliminar registros académicos
- `procesar_registrar.php` - Procesa peticiones AJAX para registrar información académica

### Modales
Ubicados en: `private/modales/modal_planeacion/gestion_academica/`

- `modal_registrar.php` - Modal para registrar nueva información académica
- `modal_editar.php` - Modal para editar información académica existente
- `modal_eliminar.php` - Modal para confirmar eliminación de registros académicos

### Funcionalidades

#### Registro de Información Académica
- Búsqueda de alumno por número de control
- Validación de existencia del alumno en el sistema
- Selección de carrera, semestre y periodo
- Registro de promedio académico
- Validaciones de integridad de datos

#### Edición de Información Académica
- Edición de carrera asignada
- Cambio de semestre actual
- Actualización de periodo académico
- Modificación de promedio
- Validaciones de consistencia

#### Eliminación de Registros Académicos
- **Eliminación Completa**: Elimina permanentemente el registro
- **Eliminación Suave**: Marca el registro como eliminado pero lo conserva
- Confirmación con detalles completos del registro

### Validaciones Implementadas

#### Campos de Identificación
- Alumno ID: Debe existir en la tabla de alumnos
- Número de control: Validación de formato (8 dígitos)

#### Campos Académicos
- Carrera: Debe ser una de las carreras válidas del sistema
- Semestre: Entre 1 y 12
- Periodo: Debe ser uno de los periodos académicos válidos
- Promedio: Entre 0 y 100 con hasta 2 decimales

#### Carreras Válidas
- ISC - Ing. en Sistemas Computacionales
- IEM - Ing. Electromecánica
- IGE - Ing. en Gestión Empresarial
- II - Ing. Industrial
- IC - Ing. Civil
- IM - Ing. Mecánica
- IE - Ing. Electrónica
- LA - Lic. en Administración
- LC - Lic. en Contaduría

#### Periodos Académicos Válidos
- ENE-JUN (Enero - Junio)
- AGO-DIC (Agosto - Diciembre)
- ENE-MAY (Enero - Mayo)
- SEP-DIC (Septiembre - Diciembre)
- FEB-JUN (Febrero - Junio)
- JUL-NOV (Julio - Noviembre)

### Seguridad
- Verificación de sesión en todos los procesadores
- Validación de método HTTP (solo POST para modificaciones)
- Sanitización de datos de entrada
- Manejo de errores con try-catch
- Validación de tipos de datos

### Base de Datos

#### Tabla Principal: `alumnos_academica`
- `academica_id` - ID único del registro académico
- `academica_alumno_id` - ID del alumno (FK)
- `academica_carrera_id` - ID/Código de la carrera
- `academica_semestre` - Semestre actual
- `academica_periodo` - Periodo académico
- `academica_promedio` - Promedio académico
- `academica_eliminado` - Marca de eliminación suave
- `academica_fecha_eliminacion` - Fecha de eliminación suave
- `academica_fecha_modificacion` - Fecha de última modificación

#### Relaciones
- Relación con tabla `alumnos` mediante `academica_alumno_id`
- Relación con tabla `carreras` (si existe) mediante `academica_carrera_id`

### Funcionalidades Especiales

#### Búsqueda de Alumnos
- Búsqueda en tiempo real por número de control
- Autocompletado de información del alumno
- Validación de existencia antes del registro

#### Interfaz de Usuario
- Modales responsivos con Bootstrap
- Validación en tiempo real
- Mensajes de confirmación y error
- Indicadores de carga durante procesamiento

### Mantenimiento

#### Para Agregar Nuevas Carreras
1. Actualizar array de carreras válidas en procesadores
2. Actualizar opciones en los modales
3. Verificar consistencia en base de datos
4. Actualizar documentación

#### Para Modificar Periodos Académicos
1. Actualizar array de periodos válidos
2. Actualizar opciones en selects de modales
3. Considerar migración de datos existentes
4. Actualizar validaciones

#### Para Cambios en Validaciones
1. Actualizar clases de procesamiento
2. Actualizar procesadores AJAX
3. Actualizar validaciones JavaScript en modales
4. Probar todas las combinaciones de datos

### Notas Importantes
- Los modales incluyen su propio JavaScript para evitar conflictos
- Las rutas utilizan constantes definidas en `config.php`
- Todos los procesadores devuelven respuestas JSON
- Se implementa eliminación suave para mantener historial
- La búsqueda de alumnos requiere que el array `window.alumnos` esté disponible

### Troubleshooting

#### Error: "No autorizado"
- Verificar que la sesión esté iniciada
- Verificar que el usuario tenga tipo 'personal'

#### Error: "Alumno no encontrado"
- Verificar que el array `window.alumnos` esté cargado
- Verificar que el número de control sea correcto
- Verificar que el alumno exista en la base de datos

#### Error: "Carrera no válida"
- Verificar que la carrera esté en el array de carreras válidas
- Verificar que el valor del select coincida con las opciones

#### Modal no se abre
- Verificar que Bootstrap esté cargado
- Verificar que los IDs de los elementos coincidan
- Revisar consola del navegador para errores JavaScript

#### Problemas con Promedio
- Verificar que se use punto decimal (no coma)
- Verificar que esté entre 0 y 100
- Verificar que tenga máximo 2 decimales