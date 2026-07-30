# Product Backlog del Proyecto
## Sistema Web para la Gestión del Patrimonio Cultural del Ecuador

**Metodología:** Scrum

**Duración del Sprint:** 2 semanas (10 días laborables)

**Duración Total:** 22 semanas

### Niveles de prioridad

| Prioridad | Descripción |
|-----------|-------------|
| 🔴 Crítica | Imprescindible para que el sistema funcione (MVP). |
| 🟠 Alta | Funcionalidades principales del sistema. |
| 🟡 Media | Mejoran significativamente la experiencia del usuario. |
| 🟢 Baja | Funcionalidades complementarias y de optimización. |

---

# Sprint 0 - Configuración del Proyecto

**Duración:** 1 semana

**Prioridad:** 🔴 Crítica

## Objetivo

Preparar todo el entorno de desarrollo.

### Tareas

| Tarea | Prioridad |
|--------|-----------|
| Crear repositorio Git | 🔴 |
| Configurar Laravel 12 | 🔴 |
| Configurar Base de Datos MySQL | 🔴 |
| Configurar FilamentPHP | 🔴 |
| Configurar autenticación | 🔴 |
| Configurar almacenamiento (Storage) | 🔴 |
| Configurar control de versiones | 🔴 |
| Configurar variables de entorno (.env) | 🔴 |
| Configurar Docker (opcional) | 🟢 |
| Crear documentación inicial | 🟡 |

### Entregable

Proyecto listo para comenzar el desarrollo.

---

# Sprint 1 - Usuarios y Seguridad

**Duración:** 2 semanas

**Prioridad:** 🔴 Crítica

## Objetivo

Implementar el sistema de autenticación y administración de usuarios.

### Tareas

| Tarea | Prioridad |
|--------|-----------|
| CRUD Roles | 🔴 |
| CRUD Usuarios | 🔴 |
| Inicio de sesión | 🔴 |
| Cierre de sesión | 🔴 |
| Recuperación de contraseña | 🔴 |
| Recordar sesión | 🔴 |
| Verificación de correo | 🟠 |
| Cambio de contraseña | 🔴 |
| Perfil del usuario | 🟠 |
| Soft Deletes | 🟠 |
| Middleware por Roles | 🔴 |

### Entregable

Sistema de autenticación completamente funcional.

---

# Sprint 2 - Catálogos Generales

**Duración:** 2 semanas

**Prioridad:** 🔴 Crítica

## Objetivo

Crear los catálogos base del sistema.

### Tareas

| Tarea | Prioridad |
|--------|-----------|
| CRUD Provincias | 🔴 |
| CRUD Cantones | 🔴 |
| CRUD Parroquias | 🔴 |
| CRUD Categorías | 🔴 |
| CRUD Tipos de Obra | 🔴 |
| CRUD Estados de Conservación | 🔴 |
| Slugs automáticos | 🟠 |
| Validaciones | 🔴 |
| Soft Delete | 🟠 |

### Entregable

Todos los catálogos implementados.

---

# Sprint 3 - Gestión de Artistas

**Duración:** 2 semanas

**Prioridad:** 🟠 Alta

## Objetivo

Administrar la información de los artistas.

### Tareas

| Tarea | Prioridad |
|--------|-----------|
| CRUD Artistas | 🟠 |
| Fotografía del artista | 🟠 |
| Biografía | 🟠 |
| Sitio web | 🟡 |
| Nacionalidad | 🟠 |
| Buscador | 🟠 |
| Soft Delete | 🟠 |

### Entregable

Módulo completo de artistas.

---

# Sprint 4 - Gestión de Obras

**Duración:** 3 semanas

**Prioridad:** 🔴 Crítica

## Objetivo

Desarrollar el módulo principal del sistema.

### Tareas

| Tarea | Prioridad |
|--------|-----------|
| CRUD Obras | 🔴 |
| Código único | 🔴 |
| Ubicación geográfica | 🔴 |
| Categoría | 🔴 |
| Tipo de obra | 🔴 |
| Estado de conservación | 🔴 |
| Provincia/Cantón/Parroquia | 🔴 |
| SEO | 🟠 |
| Estado de publicación | 🟠 |
| Validaciones | 🔴 |
| Soft Delete | 🟠 |

### Entregable

Sistema de gestión de obras terminado.

---

# Sprint 5 - Multimedia

**Duración:** 2 semanas

**Prioridad:** 🟠 Alta

## Objetivo

Administrar imágenes, documentos y videos.

### Tareas

| Tarea | Prioridad |
|--------|-----------|
| Subir imágenes | 🟠 |
| Imagen principal | 🟠 |
| Orden de imágenes | 🟡 |
| ALT de imágenes | 🟡 |
| Gestión de documentos | 🟠 |
| Contador de descargas | 🟡 |
| Gestión de videos | 🟡 |
| Miniaturas | 🟢 |

### Entregable

Sistema multimedia completo.

---

# Sprint 6 - Relaciones y Contenido

**Duración:** 2 semanas

**Prioridad:** 🟠 Alta

## Objetivo

Relacionar las obras con el resto del contenido.

### Tareas

| Tarea | Prioridad |
|--------|-----------|
| Relación Obras-Artistas | 🟠 |
| Tags | 🟡 |
| Comentarios | 🟠 |
| Moderación de comentarios | 🟡 |
| Favoritos | 🟡 |
| Calificaciones | 🟠 |
| Promedio de valoraciones | 🟡 |

### Entregable

Las obras tendrán interacción con los usuarios.

---

# Sprint 7 - Fuentes y Restauraciones

**Duración:** 2 semanas

**Prioridad:** 🟡 Media

## Objetivo

Registrar el historial documental.

### Tareas

| Tarea | Prioridad |
|--------|-----------|
| CRUD Fuentes bibliográficas | 🟡 |
| CRUD Restauraciones | 🟡 |
| ISBN | 🟢 |
| URL de referencia | 🟢 |
| Organización restauradora | 🟢 |

### Entregable

Historial documental de cada obra.

---

# Sprint 8 - Portal Público

**Duración:** 2 semanas

**Prioridad:** 🔴 Crítica

## Objetivo

Desarrollar la interfaz pública del sistema.

### Tareas

| Tarea | Prioridad |
|--------|-----------|
| Página Inicio | 🔴 |
| Listado de obras | 🔴 |
| Detalle de obra | 🔴 |
| Buscador | 🔴 |
| Filtros | 🟠 |
| Paginación | 🟠 |
| Responsive | 🔴 |
| SEO básico | 🟠 |
| Mapa de ubicación | 🟠 |

### Entregable

Portal web público funcionando.

---

# Sprint 9 - Estadísticas y Auditoría

**Duración:** 2 semanas

**Prioridad:** 🟡 Media

## Objetivo

Generar estadísticas y auditoría.

### Tareas

| Tarea | Prioridad |
|--------|-----------|
| Dashboard | 🟡 |
| Estadísticas de visitas | 🟡 |
| Obras más vistas | 🟡 |
| Usuarios registrados | 🟢 |
| Auditoría del sistema | 🟡 |
| Registro de acciones | 🟡 |

### Entregable

Panel administrativo con métricas.

---

# Sprint 10 - Optimización y Despliegue

**Duración:** 2 semanas

**Prioridad:** 🟢 Baja

## Objetivo

Preparar el sistema para producción.

### Tareas

| Tarea | Prioridad |
|--------|-----------|
| Optimización SQL | 🟢 |
| Caché | 🟢 |
| Optimización de consultas | 🟢 |
| Pruebas Unitarias | 🟡 |
| Pruebas Funcionales | 🟡 |
| Manual Técnico | 🟡 |
| Manual de Usuario | 🟡 |
| Despliegue en servidor | 🟢 |
| Configuración SSL | 🟢 |
| Backups | 🟢 |

### Entregable

Sistema listo para producción.

---

# Cronograma General

| Sprint | Nombre | Duración | Prioridad |
|---------|---------|-----------|-----------|
| Sprint 0 | Configuración del proyecto | 1 semana | 🔴 Crítica |
| Sprint 1 | Usuarios y seguridad | 2 semanas | 🔴 Crítica |
| Sprint 2 | Catálogos generales | 2 semanas | 🔴 Crítica |
| Sprint 3 | Gestión de artistas | 2 semanas | 🟠 Alta |
| Sprint 4 | Gestión de obras | 3 semanas | 🔴 Crítica |
| Sprint 5 | Multimedia | 2 semanas | 🟠 Alta |
| Sprint 6 | Relaciones y contenido | 2 semanas | 🟠 Alta |
| Sprint 7 | Fuentes y restauraciones | 2 semanas | 🟡 Media |
| Sprint 8 | Portal público | 2 semanas | 🔴 Crítica |
| Sprint 9 | Estadísticas y auditoría | 2 semanas | 🟡 Media |
| Sprint 10 | Optimización y despliegue | 2 semanas | 🟢 Baja |

---

# MVP (Producto Mínimo Viable)

Las funcionalidades que deben estar listas para considerar el sistema funcional son:

- 🔴 Configuración del proyecto.
- 🔴 Sistema de autenticación.
- 🔴 Gestión de usuarios y roles.
- 🔴 Catálogos (provincias, cantones, parroquias, categorías, tipos y estados).
- 🔴 Gestión de artistas.
- 🔴 Gestión de obras.
- 🟠 Carga de imágenes.
- 🔴 Portal público.
- 🔴 Buscador de obras.
- 🔴 Geolocalización de obras.
- 🟠 Comentarios.
- 🟠 Calificaciones.

Una vez completados estos módulos, el sistema podrá utilizarse de forma operativa. Las funcionalidades restantes pueden incorporarse progresivamente en versiones posteriores.