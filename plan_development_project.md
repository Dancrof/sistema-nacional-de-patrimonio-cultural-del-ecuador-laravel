# Plan de Desarrollo del MVP

## 1. Objetivo del MVP

El MVP tendrá como objetivo desarrollar una plataforma web para la gestión y consulta de obras de patrimonio cultural del Ecuador, permitiendo a los administradores gestionar la información desde un panel administrativo desarrollado con Laravel + AdminLTE + Livewire, mientras que los usuarios podrán consultar las obras publicadas e interactuar con ellas mediante componentes reactivos sin necesidad de recargar la página.

---

## 2. Tecnologías

| Tecnología | Uso |
|---|---|
| Laravel | Framework principal |
| PHP | Lenguaje de programación |
| MySQL | Sistema gestor de base de datos |
| AdminLTE | Interfaz del panel administrativo |
| **Livewire 4** | **Componentes reactivos (Single-File Components) para CRUDs, búsqueda, filtros, comentarios y calificaciones en vivo** |
| Blade | Motor de plantillas |
| Eloquent ORM | Acceso a la base de datos |
| HTML5 / CSS3 / JavaScript | Interfaz web |
| Git | Control de versiones |

> **Nota sobre Livewire 4:** introduce los *Single-File Components* (componentes de archivo único), donde la lógica PHP y la vista Blade conviven en un mismo archivo con el prefijo `⚡` (por ejemplo, `resources/views/pages/post/⚡create.blade.php`). El MVP adoptará esta convención para los módulos administrativos y de interacción pública que se listan en cada sprint.

---

## 3. Módulos incluidos en el MVP

| Módulo | Tablas | Prioridad |
|---|---|---|
| Configuración del proyecto | — | 🔴 Crítica |
| Autenticación y autorización | `users`, `roles`, `sessions`, `password_reset_tokens` | 🔴 Crítica |
| Gestión de usuarios | `users`, `roles` | 🔴 Crítica |
| Gestión geográfica | `provinces`, `cantons`, `parishes` | 🔴 Crítica |
| Catálogos | `categories`, `artwork_types`, `conservation_statuses` | 🔴 Crítica |
| Gestión de artistas | `artists` | 🔴 Crítica |
| Gestión de obras | `artworks`, `artwork_artist` | 🔴 Crítica |
| Gestión de imágenes | `artwork_images` | 🔴 Crítica |
| Geolocalización | `artworks.latitude`, `artworks.longitude` | 🟠 Alta |
| Portal público | `artworks`, `artists`, `provinces`, etc. | 🔴 Crítica |
| Búsqueda y filtros | `artworks` | 🔴 Crítica |
| Comentarios | `comments` | 🟠 Alta |
| Calificaciones | `ratings` | 🟠 Alta |
| Pruebas y documentación | Todo el sistema | 🔴 Crítica |

---

## 4. Funcionalidades fuera del MVP

Las siguientes tablas permanecerán en el diseño de la base de datos, pero su implementación se realizará posteriormente:

- `artwork_videos`
- `artwork_documents`
- `tags`
- `artwork_tag`
- `favorites`
- `artwork_sources`
- `restoration_events`
- `artwork_views`
- `audit_logs`

Estas funcionalidades pueden formar parte de una **Versión 2** del sistema.

---

## 5. Sprint 0 — Preparación del proyecto

**Duración:** 1 semana
**Prioridad:** 🔴 Crítica

### Objetivo

Preparar el entorno de desarrollo y establecer la estructura inicial del proyecto Laravel.

### Tareas

| Tarea | Descripción |
|---|---|
| Configuración de Laravel | Configurar el proyecto base |
| Configuración de MySQL | Conectar Laravel con la BD |
| Configuración del `.env` | Definir las variables del proyecto |
| Instalación de AdminLTE | Configurar el panel administrativo |
| **Instalación de Livewire 4** | **Configurar componentes reactivos y convención de Single-File Components (`⚡`)** |
| Configuración de almacenamiento | Preparar almacenamiento de imágenes |
| Configuración de Git | Crear repositorio y control de versiones |
| Migraciones iniciales | Crear estructura inicial de la BD |
| Configuración regional | Idioma español y zona horaria de Ecuador |
| Estructura del proyecto | Organizar modelos, controladores, vistas, componentes Livewire y rutas |

### Resultado esperado

```
Laravel
   │
   ├── MySQL
   │
   ├── AdminLTE
   │      │
   │      └── Panel administrativo
   │
   └── Livewire 4
          │
          └── Componentes reactivos (SFC)
```

---

## 6. Sprint 1 — Autenticación, autorización y usuarios

**Duración:** 2 semanas
**Prioridad:** 🔴 Crítica

### Objetivo

Implementar el acceso seguro al sistema utilizando Laravel para la autenticación y autorización y AdminLTE como interfaz administrativa.

### Tablas involucradas

```
roles
   │
   └── users
          │
          └── sessions
```

### Tareas

| Tarea | Descripción |
|---|---|
| Configurar modelo `User` | Adaptarlo a la estructura personalizada de `users` |
| Implementar login | Autenticación mediante Laravel |
| Implementar logout | Cierre de sesión |
| Recuperación de contraseña | Utilizar `password_reset_tokens` |
| Configurar sesiones | Utilizar la tabla `sessions` |
| Crear modelo `Role` | Gestionar los roles |
| Relacionar `User` y `Role` | Implementar relaciones Eloquent |
| Crear middleware de roles | Restringir acceso según el rol |
| Crear roles iniciales | Administrador, gestor, moderador y usuario |
| Crear dashboard | Panel administrativo con AdminLTE |
| **CRUD de usuarios con Livewire** | **Componente `⚡index`, `⚡create`, `⚡edit` con tabla reactiva, búsqueda y paginación sin recarga** |
| Gestión de perfil | Datos personales y avatar (formulario reactivo con Livewire, previsualización de avatar en vivo) |
| Registrar último acceso | Utilizar `last_login_at` |

### Roles iniciales

| Rol | Función |
|---|---|
| Administrador | Administración completa del sistema |
| Gestor | Gestión de obras, artistas y catálogos |
| Moderador | Moderación de comentarios |
| Usuario | Consulta e interacción con las obras |

### Resultado esperado

```
Usuario
   ↓
Login
   ↓
Laravel Auth
   ↓
Validación de credenciales
   ↓
Verificación de is_active
   ↓
Obtención del rol
   ↓
Autorización
   ↓
AdminLTE
```

---

## 7. Sprint 2 — Gestión geográfica

**Duración:** 2 semanas
**Prioridad:** 🔴 Crítica

### Objetivo

Implementar la estructura geográfica del Ecuador para asociar cada obra con su ubicación.

### Tablas

```
provinces
    │
    └── cantons
           │
           └── parishes
```

### Tareas

| Tarea | Descripción |
|---|---|
| Modelo `Province` | Crear modelo y relaciones |
| Modelo `Canton` | Crear modelo y relaciones |
| Modelo `Parish` | Crear modelo y relaciones |
| CRUD de provincias | Administración mediante AdminLTE |
| CRUD de cantones | Administración mediante AdminLTE |
| CRUD de parroquias | Administración mediante AdminLTE |
| Seeders | Cargar información geográfica |
| Validaciones | Evitar duplicados |
| **Select dependiente con Livewire** | **Componente reactivo Provincia → Cantón → Parroquia, sin JavaScript manual ni recarga de página** |

### Resultado esperado

Al registrar una obra se podrá seleccionar:

```
Provincia
    ↓
Cantón
    ↓
Parroquia
```

---

## 8. Sprint 3 — Catálogos del patrimonio

**Duración:** 2 semanas
**Prioridad:** 🔴 Crítica

### Objetivo

Crear los catálogos utilizados para clasificar las obras.

### Tablas

- `categories`
- `artwork_types`
- `conservation_statuses`

### Tareas

| Tarea | Descripción |
|---|---|
| CRUD de categorías | Crear, editar, consultar y eliminar (componente Livewire `⚡index`) |
| CRUD de tipos de obra | Administrar tipos (componente Livewire) |
| CRUD de estados de conservación | Administrar estados (componente Livewire) |
| Seeders | Registrar información inicial |
| Validaciones | Controlar nombres y slugs (validación en vivo con Livewire) |
| Relaciones | Relacionar catálogos con obras |
| Interfaz AdminLTE | Crear las vistas administrativas |

### Resultado esperado

Una obra podrá clasificarse mediante:

```
Categoría
     +
Tipo de obra
     +
Estado de conservación
```

---

## 9. Sprint 4 — Gestión de artistas

**Duración:** 2 semanas
**Prioridad:** 🔴 Crítica

### Tabla principal

`artists`

### Tareas

| Funcionalidad | Campo |
|---|---|
| Nombres | `first_name` |
| Apellidos | `last_name` |
| Nombre completo | `full_name` |
| Fecha de nacimiento | `birth_date` |
| Lugar de nacimiento | `birth_place` |
| Fecha de fallecimiento | `death_date` |
| Estado de fallecimiento | `is_deceased` |
| Nacionalidad | `nationality` |
| Biografía | `biography` |
| Imagen | `profile_image` |
| Sitio web | `website` |

### Funcionalidades

- Crear artistas.
- Editar artistas.
- Consultar información.
- Eliminar artistas mediante soft delete.
- Subir fotografía de perfil (subida reactiva con previsualización, mediante Livewire).
- Buscar artistas (búsqueda en vivo con Livewire, sin recargar la página).
- Consultar obras asociadas.

### Resultado esperado

```
Artista
   │
   └── Obras asociadas
```

---

## 10. Sprint 5 — Gestión de obras patrimoniales

**Duración:** 3 semanas
**Prioridad:** 🔴 Crítica

### Objetivo

Desarrollar el módulo principal del sistema para registrar y administrar las obras de patrimonio cultural.

### Tabla principal

`artworks`

### Relaciones

```
artworks
   │
   ├── categories
   ├── artwork_types
   ├── conservation_statuses
   ├── provinces
   ├── cantons
   ├── parishes
   ├── users
   │
   └── artwork_artist
           │
           └── artists
```

### Información de la obra

| Grupo | Información |
|---|---|
| Identificación | Código, título, slug |
| Descripción | Descripción corta y completa |
| Historia | Contexto histórico |
| Clasificación | Categoría y tipo |
| Conservación | Estado de conservación |
| Ubicación | Provincia, cantón, parroquia y dirección |
| Autoría | Uno o varios artistas |
| Características | Año, dimensiones y peso |
| Valor | Valor estimado |
| Accesibilidad | Notas de accesibilidad |
| Geolocalización | Latitud y longitud |
| Publicación | Estado, fecha y usuario que publicó |
| SEO | Título y descripción SEO |

### Flujo de publicación

El campo `status` permitirá implementar:

```
borrador
    ↓
pendiente
    ↓
publicado
    ↓
archivado
```

Por ejemplo:

```
Gestor
   ↓
Crea obra
   ↓
Borrador
   ↓
Envía para revisión
   ↓
Pendiente
   ↓
Administrador
   ↓
Publicado
```

### Resultado esperado

CRUD completo de obras mediante AdminLTE, implementado como componentes Livewire 4 (`⚡index`, `⚡create`, `⚡edit`) que permiten guardar borradores automáticamente, validar campos en vivo y cambiar el `status` de la obra sin recargar la página.

---

## 11. Sprint 6 — Imágenes y geolocalización

**Duración:** 2 semanas
**Prioridad:** 🟠 Alta

### Tabla

`artwork_images`

### Tareas

| Funcionalidad | Descripción |
|---|---|
| Subir imágenes | Componente Livewire con subida múltiple y previsualización en vivo, asociadas a una obra |
| Eliminar imágenes | Gestionar archivos de forma reactiva (sin recargar la galería) |
| Imagen de portada | Definir imagen principal con selección instantánea |
| Orden | Controlar presentación (reordenamiento reactivo tipo drag & drop con Livewire) |
| Pie de imagen | Campo `caption` |
| Texto alternativo | Campo `alt_text` |
| Información técnica | Tamaño, dimensiones y MIME |
| Hash | Identificación de imágenes |
| Almacenamiento | Configurar Laravel Storage |

### Geolocalización

Utilizar:

- `artworks.latitude`
- `artworks.longitude`

para mostrar la ubicación de la obra mediante un mapa.

### Resultado esperado

```
Obra
 ├── Imagen de portada
 ├── Imagen 2
 ├── Imagen 3
 └── Imagen 4

Obra
 └── Ubicación en mapa
```

---

## 12. Sprint 7 — Portal público e interacción

**Duración:** 2 semanas
**Prioridad:** 🔴 Crítica

### Objetivo

Crear la interfaz pública donde los visitantes podrán consultar el patrimonio registrado.

### Portal público

El usuario podrá, mediante componentes Livewire 4 (Single-File Components) que actualizan la página sin recargarla:

- Consultar obras publicadas.
- Consultar artistas.
- Consultar provincias.
- Ver información detallada de cada obra.
- Visualizar imágenes (galería reactiva).
- Consultar ubicación.
- Buscar obras (búsqueda en vivo, `wire:model.live`).
- Filtrar obras.

### Filtros

Implementados como un único componente Livewire de tipo página (`pages::obras.⚡index`), que reacciona a cada cambio sin recargar el listado:

```
Buscar (componente Livewire reactivo)
   │
   ├── Título
   ├── Provincia
   ├── Cantón
   ├── Categoría
   ├── Tipo de obra
   └── Estado de conservación
```

### Comentarios

**Tabla:** `comments`

Funcionalidades (componente Livewire `⚡comments`, embebido en la página de detalle de la obra):

- Crear comentarios (envío sin recarga de página).
- Editar comentarios propios en línea.
- Eliminar comentarios propios con confirmación reactiva.
- Responder comentarios (hilos anidados renderizados dinámicamente).
- Moderar comentarios (panel administrativo con Livewire).

### Calificaciones

**Tabla:** `ratings`

El usuario podrá asignar una valoración de 1 a 5 estrellas mediante un componente Livewire de estrellas interactivo, que actualiza `average_rating` de la obra en tiempo real sin recargar la página.

La restricción:

```
UNIQUE(user_id, artwork_id)
```

garantizará que cada usuario tenga una única valoración por obra.

---

## 13. Sprint 8 — Pruebas y entrega del MVP

**Duración:** 1 semana
**Prioridad:** 🔴 Crítica

### Checklist final de validación del MVP

#### Pruebas de autenticación

- [x] Login correcto.
- [x] Login con credenciales incorrectas.
- [x] Usuario inactivo.
- [x] Logout.
- [ ] Recuperación de contraseña.
- [x] Control de sesión.

#### Pruebas de autorización

- [x] Administrador.
- [x] Gestor.
- [x] Moderador.
- [x] Usuario.
- [x] Acceso no autorizado a módulos.

#### Pruebas de obras

- [x] Crear obra.
- [x] Editar obra.
- [x] Consultar obra.
- [x] Publicar obra.
- [x] Archivar obra.
- [x] Buscar obra.
- [x] Filtrar obra.

#### Pruebas de ubicación

- [x] Provincia.
- [x] Cantón.
- [x] Parroquia.
- [x] Ubicación geográfica.

#### Pruebas de interacción

- [x] Crear comentario.
- [ ] Editar comentario.
- [ ] Eliminar comentario.
- [x] Calificar obra.
- [x] Modificar calificación.
- [x] Impedir calificaciones duplicadas.

#### Pruebas de componentes Livewire

- [ ] Renderizado correcto de componentes SFC (`⚡`).
- [ ] Validación en vivo en formularios reactivos.
- [ ] Búsqueda y filtros sin recarga de página.

### Estado del Sprint 8

El MVP funcional quedó validado en la capa de backend y en la experiencia pública del catálogo, con cobertura de prueba para autenticación, autorización, gestión de obras, geografía, portal público, comentarios y valoraciones. Los puntos pendientes corresponden a refinamientos avanzados de UX o a la evolución hacia un stack Livewire completo para interacciones más dinámicas sin recarga.
- [ ] Subida y previsualización de imágenes.
- [ ] Actualización de calificaciones en tiempo real.

### Documentación

- [ ] Manual de instalación.
- [ ] Manual de usuario.
- [ ] Manual de administrador.
- [ ] Documentación de la BD.
- [ ] Documentación de pruebas.
- [ ] Documentación del MVP.

---

## 14. Cronograma general

| Sprint | Módulo | Duración | Prioridad |
|---|---|---|---|
| 0 | Preparación Laravel + AdminLTE | 1 semana | 🔴 |
| 1 | Autenticación, autorización y usuarios | 2 semanas | 🔴 |
| 2 | Provincias, cantones y parroquias | 2 semanas | 🔴 |
| 3 | Catálogos del patrimonio | 2 semanas | 🔴 |
| 4 | Artistas | 2 semanas | 🔴 |
| 5 | Obras patrimoniales | 3 semanas | 🔴 |
| 6 | Imágenes + geolocalización | 2 semanas | 🟠 |
| 7 | Portal público + comentarios + ratings | 2 semanas | 🔴 |
| 8 | Pruebas + documentación + entrega | 1 semana | 🔴 |
| **Total** | **MVP** | **15 semanas** | |

---

## 15. Funcionalidades de la versión 2

Una vez terminado el MVP, se podrán implementar las tablas restantes:

| Funcionalidad | Tabla |
|---|---|
| Etiquetas | `tags`, `artwork_tag` |
| Favoritos | `favorites` |
| Videos | `artwork_videos` |
| Documentos | `artwork_documents` |
| Fuentes bibliográficas | `artwork_sources` |
| Restauraciones | `restoration_events` |
| Estadísticas de visitas | `artwork_views` |
| Auditoría | `audit_logs` |

También se podrán incorporar posteriormente:

- Notificaciones.
- Estadísticas avanzadas.
- SEO avanzado.
- API REST.
- Aplicación móvil.
- Sistema avanzado de permisos.
- Reportes.
- Exportación de información.

---

## 16. Resultado final del MVP

Al finalizar las 15 semanas, el sistema deberá permitir:

```
                    PLATAFORMA
                        │
          ┌─────────────┴─────────────┐
          │                           │
    PANEL ADMINISTRATIVO          PORTAL PÚBLICO
       AdminLTE                       │
          │                           │
    ┌─────┴─────┐              ┌──────┴──────┐
    │           │              │             │
 Usuarios    Catálogos       Buscar       Consultar
    │           │              │             │
    │        Geografía        Filtrar       Obras
    │           │              │             │
    └───────────┴──────────────┴─────────────┘
                         │
                       Obras
                         │
          ┌──────────────┼──────────────┐
          │              │              │
       Artistas       Imágenes      Ubicación
          │              │              │
          └──────────────┼──────────────┘
                         │
                  Interacción
                    ┌────┴────┐
                    │         │
                Comentarios  Ratings
                    │         │
                    └────┬────┘
                         │
              Componentes Livewire 4
              (reactivos, sin recarga)
```

---

*Este sería el plan base que utilizaría para desarrollar tu BD actual en Laravel, sin modificar la estructura que ya tienes y dejando las funcionalidades secundarias para una segunda versión.*