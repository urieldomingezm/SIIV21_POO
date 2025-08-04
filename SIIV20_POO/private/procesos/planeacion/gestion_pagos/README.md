# Gestión de Pagos - Documentación

## Estructura del Sistema

### Archivos Principales

#### Clases de Procesamiento
- `pago_mostrar.php` - Clase para mostrar y obtener datos de pagos
- `pago_editar.php` - Clase para editar registros de pagos
- `pago_eliminar.php` - Clase para eliminar registros de pagos (completa y suave)
- `pago_registrar.php` - Clase para registrar nuevos pagos

#### Procesadores AJAX
- `procesar_editar.php` - Procesa peticiones AJAX para editar pagos
- `procesar_eliminar.php` - Procesa peticiones AJAX para eliminar pagos
- `procesar_registrar.php` - Procesa peticiones AJAX para registrar pagos

### Modales
Ubicados en: `private/modales/modal_planeacion/gestion_pagos/`

- `modal_registrar.php` - Modal para registrar nuevos pagos
- `modal_editar.php` - Modal para editar pagos existentes
- `modal_eliminar.php` - Modal para confirmar eliminación de pagos

### Funcionalidades

#### Registro de Pagos
- Validación de número de control (8 dígitos)
- Validación de nombres y apellidos (solo letras y espacios)
- Cálculo automático del total basado en descuento
- Precio base: $3,200.00 MXN

#### Edición de Pagos
- Edición de descuento
- Cambio de estado de pago (pagado/pendiente)
- Recálculo automático del total
- Validaciones de integridad

#### Eliminación de Pagos
- **Eliminación Completa**: Elimina permanentemente el registro
- **Eliminación Suave**: Marca el registro como eliminado pero lo conserva
- Validación para prevenir eliminación de pagos ya realizados

### Validaciones Implementadas

#### Campos de Texto
- Nombres y apellidos: Solo letras, espacios y acentos
- Número de control: Exactamente 8 dígitos numéricos

#### Campos Numéricos
- Descuento: Entre 0 y 100%
- Semestre: Entre 1 y 12

#### Campos de Selección
- Carrera: ISC, IEM, IGE, II
- Periodo: ENE-JUN, AGO-DIC

### Seguridad
- Verificación de sesión en todos los procesadores
- Validación de método HTTP (solo POST para modificaciones)
- Sanitización de datos de entrada
- Manejo de errores con try-catch

### Base de Datos

#### Tabla Principal: `alumnos_pagos`
- `pagos_id` - ID único del pago
- `pagos_alumno_id` - ID del alumno (FK)
- `pagos_nombre` - Nombre del alumno
- `pagos_apellido` - Apellidos del alumno
- `pagos_carrera` - Carrera del alumno
- `pagos_semestre` - Semestre actual
- `pagos_periodo` - Periodo académico
- `pagos_descuento` - Porcentaje de descuento
- `pagos_total` - Total a pagar
- `pagos_realizado` - Estado del pago (0/1)
- `pagos_eliminado` - Marca de eliminación suave
- `pagos_fecha_eliminacion` - Fecha de eliminación suave
- `pagos_fecha_modificacion` - Fecha de última modificación

### Mantenimiento

#### Para Agregar Nuevas Funcionalidades
1. Crear método en la clase correspondiente
2. Crear procesador AJAX si es necesario
3. Actualizar modal si requiere interfaz
4. Documentar cambios en este archivo

#### Para Modificar Validaciones
1. Actualizar clase de procesamiento
2. Actualizar procesador AJAX
3. Actualizar validaciones JavaScript en modal
4. Probar todas las combinaciones

#### Para Cambios en la Base de Datos
1. Actualizar consultas SQL en las clases
2. Actualizar validaciones según nuevos campos
3. Actualizar modales si es necesario
4. Migrar datos existentes si es requerido

### Notas Importantes
- El precio base está definido como constante en las clases
- Los modales incluyen su propio JavaScript para evitar conflictos
- Las rutas utilizan constantes definidas en `config.php`
- Todos los procesadores devuelven respuestas JSON
- Se implementa eliminación suave para mantener historial

### Troubleshooting

#### Error: "No autorizado"
- Verificar que la sesión esté iniciada
- Verificar que el usuario tenga tipo 'personal'

#### Error: "Método no permitido"
- Verificar que se esté usando POST para modificaciones
- Verificar la URL del fetch en JavaScript

#### Error: "Campo requerido"
- Verificar validaciones HTML5 en modales
- Verificar que todos los campos requeridos se envíen

#### Modal no se abre
- Verificar que Bootstrap esté cargado
- Verificar que los IDs de los elementos coincidan
- Revisar consola del navegador para errores JavaScript