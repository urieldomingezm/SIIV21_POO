# 🎓 Sistema Integral de Información Institucional (SIIV)

## 📋 Descripción

El **Sistema Integral de Información Institucional (SIIV)** es una plataforma web desarrollada en PHP que gestiona los procesos académicos y administrativos de un instituto tecnológico. El sistema maneja tres tipos de usuarios principales: **Aspirantes**, **Alumnos** y **Personal Administrativo**.

## 🏗️ Arquitectura del Sistema

### Estructura de Directorios

```
instituto-tecnologico/
├── 📁 modulo/                    # Módulos principales por tipo de usuario
│   ├── 📁 alumno/               # Dashboard y funcionalidades de alumnos
│   ├── 📁 aspirante/            # Dashboard y funcionalidades de aspirantes
│   └── 📁 personal/             # Dashboard y funcionalidades del personal
├── 📁 planeacion/               # Módulo de planeación académica
│   └── 📁 modulo/              # Gestión académica avanzada
├── 📁 private/                  # Archivos privados del sistema
│   ├── 📁 conexion/            # Configuración de base de datos
│   ├── 📁 menu/                # Menús de navegación
│   ├── 📁 modales/             # Modales del sistema
│   ├── 📁 plantillas/          # Templates HTML
│   └── 📁 procesos/            # Lógica de negocio
├── 📁 public/                   # Recursos públicos (CSS, JS, imágenes)
├── 📄 index.php                 # Página principal de login
├── 📄 config.php               # Configuración global
├── 📄 docker-compose.yml       # Configuración Docker
└── 📄 instituto_tecnologico.sql # Base de datos
```

## 🚀 Instalación y Configuración

### Requisitos Previos

- **Docker** y **Docker Compose**
- **PHP 8.2+**
- **MySQL 8.0+**
- **Apache/Nginx**

### Instalación con Docker

1. **Clonar el repositorio:**
```bash
git clone <repository-url>
cd instituto-tecnologico
```

2. **Levantar los servicios:**
```bash
docker-compose up -d
```

3. **Acceder a los servicios:**
- **Aplicación:** http://localhost:8081
- **phpMyAdmin:** http://localhost:8087
- **Base de datos:** localhost:3308

### Configuración Manual

1. **Configurar la base de datos:**
```bash
mysql -u root -p < instituto_tecnologico.sql
mysql -u root -p < tablas_faltantes.sql
```

2. **Configurar Apache:**
```apache
<VirtualHost *:80>
    DocumentRoot /path/to/instituto-tecnologico
    ServerName siiv.local
    
    <Directory /path/to/instituto-tecnologico>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

## 🗄️ Base de Datos

### Tablas Principales

| Tabla | Descripción |
|-------|-------------|
| `alumnos` | Información básica de alumnos registrados |
| `aspirantes` | Datos de aspirantes al instituto |
| `personal` | Personal administrativo del sistema |
| `carreras_institucion` | Catálogo de carreras disponibles |
| `alumnos_info_academica` | Información académica de alumnos |
| `alumnos_pagos` | Registro de pagos de alumnos |
| `aspirantes_socioeconomicos` | Datos socioeconómicos de aspirantes |

### Credenciales por Defecto

- **Base de datos:** `instituto_tecnologico`
- **Usuario:** `root`
- **Contraseña:** `password`

## 🔐 Sistema de Autenticación

### Tipos de Usuario

#### 1. 👨‍🎓 Aspirantes
- **Ruta de acceso:** `/index.php` → Pestaña "Aspirantes"
- **Funcionalidades:**
  - Registro inicial
  - Captura de datos socioeconómicos
  - Consulta de proceso de admisión

#### 2. 🎓 Alumnos
- **Ruta de acceso:** `/index.php` → Pestaña "Alumnos"
- **Credenciales:** Número de control + contraseña
- **Funcionalidades:**
  - Dashboard personal
  - Consulta de avance reticular
  - Descarga de boletas
  - Consulta de kardex

#### 3. 👨‍💼 Personal Administrativo
- **Ruta de acceso:** `/index.php` → Pestaña "Personal"
- **Credenciales:** Usuario + contraseña
- **Funcionalidades:**
  - Dashboard administrativo
  - Gestión de alumnos
  - Gestión de pagos

## 🛣️ Rutas y Endpoints

### Rutas Principales

| Ruta | Descripción | Acceso |
|------|-------------|---------|
| `/` | Página principal de login | Público |
| `/modulo/` | Redirector según tipo de usuario | Autenticado |
| `/planeacion/` | Login específico para personal | Personal |

### Módulo de Aspirantes (`/modulo/aspirante/`)

| Parámetro | Archivo | Descripción |
|-----------|---------|-------------|
| `?page=Inicio` | `ASPB.php` | Dashboard principal |
| `?page=Datos socioeconomicos` | `ASSO.php` | Captura de datos socioeconómicos |
| `?page=Fichas de pagos` | `ASFP.php` | Consulta de pagos |
| `?page=Solicitud de examen` | `ASSE.php`, `GVP.php` | Solicitud de examen |

### Módulo de Alumnos (`/modulo/alumno/`)

| Parámetro | Archivo | Descripción |
|-----------|---------|-------------|
| `?page=Inicio` | `ALUB.php` | Dashboard principal |
| `?page=Avance reticular` | `ALUAN.php` | Consulta de avance académico |
| `?page=Boletas` | `ALUBO.php` | Descarga de boletas |
| `?page=Kardex` | `ALUKA.php` | Consulta de kardex |

### Módulo de Personal (`/modulo/personal/`)

| Parámetro | Archivo | Descripción |
|-----------|---------|-------------|
| `?page=Inicio` | `PEB.php` | Dashboard principal |

### Módulo de Planeación (`/planeacion/modulo/`)

| Parámetro | Archivo | Descripción |
|-----------|---------|-------------|
| `?page=Inicio` | `PLBN.php` | Dashboard de planeación |
| `?page=Gestion de alumnos` | `PLGA.php` | Gestión académica de alumnos |
| `?page=Gestion de pagos` | `PLGP.php` | Gestión de pagos institucionales |

## 🔧 Configuración del Sistema

### Archivo `config.php`

```php
// Rutas principales del sistema
define('ROOT_PATH', __DIR__ . '/');
define('PRIVATE_PATH', ROOT_PATH.'private/');
define('PUBLIC_PATH', ROOT_PATH.'public/');

// Plantillas y menús
define('TEMPLATES_PATH', PRIVATE_PATH.'plantillas/');
define('MENU_PATH', PRIVATE_PATH.'menu/');

// Conexión y procesos
define('CONFIG_PATH', PRIVATE_PATH.'conexion/');
define('PROCESOS_PATH', PRIVATE_PATH.'procesos/');
```

### Variables de Entorno Docker

```yaml
environment:
  MYSQL_HOST: db
  MYSQL_DATABASE: instituto_tecnologico
  MYSQL_USER: root
  MYSQL_PASSWORD: password
```

## 🎨 Frontend y UI

### Tecnologías Utilizadas

- **Bootstrap 5.3+** - Framework CSS
- **Bootstrap Icons** - Iconografía
- **JavaScript Vanilla** - Interactividad
- **Canvas API** - Sistema CAPTCHA

### Características de la Interfaz

- ✅ Diseño responsivo
- ✅ Navegación por pestañas
- ✅ Modales informativos
- ✅ Sistema CAPTCHA integrado
- ✅ Breadcrumbs de navegación
- ✅ Acordeones informativos

## 🔒 Seguridad

### Medidas Implementadas

- **Autenticación por sesiones PHP**
- **Tokens CSRF** para formularios
- **Sistema CAPTCHA** personalizado
- **Validación de permisos** por módulo
- **Sanitización de datos** de entrada
- **Redirecciones automáticas** en caso de acceso no autorizado

### Gestión de Sesiones

```php
// Verificación de autenticación
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== $this->userType) {
    // Mostrar modal de error y redireccionar
    $this->showUnauthorizedModal();
    exit();
}
```

## 📊 Funcionalidades por Módulo

### 🎯 Aspirantes
- **Registro inicial** con validación CURP
- **Captura de datos socioeconómicos**
- **Información del proceso de admisión**
- **Consulta de estatus de solicitud**

### 🎓 Alumnos
- **Dashboard personalizado**
- **Consulta de avance reticular**
- **Descarga de documentos académicos**
- **Historial de calificaciones**

### 👨‍💼 Personal Administrativo
- **Gestión de alumnos**
- **Administración de pagos**
- **Reportes académicos**
- **Configuración del sistema**

### 📋 Planeación Académica
- **Gestión avanzada de alumnos**
- **Control de pagos institucionales**
- **Reportes estadísticos**
- **Administración de carreras**

## 🚀 Desarrollo y Contribución

### Estructura de Controladores

Cada módulo utiliza el patrón **Controller** para manejar las rutas:

```php
class AlumnoController {
    private $pageMapping = array(
        'Inicio' => 'ALUB.php',
        'Avance reticular' => 'ALUAN.php',
        // ...
    );
    
    public function handleRequest() {
        $page = $_GET['page'] ?? '';
        $this->loadRequestedPage($page);
    }
}
```

### Agregar Nuevas Funcionalidades

1. **Crear el archivo PHP** en el módulo correspondiente
2. **Actualizar el `pageMapping`** en el controlador
3. **Agregar la opción** en el menú correspondiente
4. **Configurar permisos** si es necesario

## 🐛 Troubleshooting

### Problemas Comunes

#### Error de conexión a base de datos
```bash
# Verificar que los servicios estén corriendo
docker-compose ps

# Revisar logs
docker-compose logs db
```

#### Problemas de permisos
```bash
# Ajustar permisos en el contenedor
docker exec -it <container_name> chown -R www-data:www-data /var/www/html
```

#### Sesiones no funcionan
- Verificar que `session_start()` esté al inicio de cada archivo
- Comprobar configuración de PHP para sesiones
- Revisar permisos del directorio de sesiones

## 📞 Soporte

### Información de Contacto del Instituto

- **Teléfono:** (867) 555-0123
- **Problemas con SIIE:** Contactar soporte técnico
- **Proceso de admisión:** Consultar fechas en el sistema

### Fechas Importantes 2025

- **Registro:** 4 febrero - 15 abril
- **Examen de admisión:** 18-19 junio  
- **Curso propedéutico:** 25 junio - 23 julio
- **Publicación de listas:** 28 julio

## 📄 Licencia

Este proyecto es de uso interno del instituto tecnológico. Todos los derechos reservados.

---

**Desarrollado para el Instituto Tecnológico** 🎓
*Sistema Integral de Información Institucional v2.0*
