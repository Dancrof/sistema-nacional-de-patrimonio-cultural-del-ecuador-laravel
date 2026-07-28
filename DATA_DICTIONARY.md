# Diccionario de Datos
## Sistema de Gestión del Patrimonio Cultural del Ecuador
---

# Tabla: users
## Descripción
Almacena la información de todos los usuarios registrados dentro del sistema.
## Relaciones
- Pertenece a un Role.
- Puede crear muchas Obras (artworks).
- Puede actualizar muchas Obras.
- Puede publicar muchas Obras.
- Puede escribir muchos Comentarios.
- Puede realizar muchas Valoraciones (ratings).
- Puede tener muchos Favoritos.
- Puede tener muchas Sesiones.
- Puede generar muchos registros de Auditoría (audit_logs).
- Puede generar muchas Vistas de obra (artwork_views).
## Campos
| Campo | Tipo | Nulo | Clave | Descripción | Ejemplo |
|--------|------|------|--------|-------------|---------|
| id | INTEGER | No | PK | Identificador único del usuario. | 1 |
| role_id | BIGINT | No | FK | Rol asignado al usuario. Referencia a roles.id. | 2 |
| first_name | VARCHAR(100) | No | | Nombres del usuario. | Bryan |
| last_name | VARCHAR(100) | No | | Apellidos del usuario. | Caicedo |
| username | VARCHAR(50) | No | UNIQUE | Nombre de usuario utilizado para iniciar sesión. | bryancaicedo |
| email | VARCHAR(150) | No | UNIQUE | Correo electrónico del usuario. | bryan@gmail.com |
| password | VARCHAR(255) | No | | Contraseña encriptada del usuario. | $2y$10$abc... |
| avatar | VARCHAR(255) | Sí | | Ruta o URL de la imagen de perfil del usuario. | avatars/bryan.jpg |
| phone | VARCHAR(20) | Sí | | Número de teléfono del usuario. | 0991234567 |
| biography | TEXT | Sí | | Breve reseña o descripción personal del usuario. | Historiador y gestor cultural. |
| email_verified_at | TIMESTAMP | Sí | | Fecha y hora en que el usuario verificó su correo. | 2025-01-10 10:00:00 |
| last_login_at | TIMESTAMP | Sí | | Fecha y hora del último inicio de sesión. | 2025-06-20 08:30:00 |
| remember_token | VARCHAR(100) | Sí | | Token utilizado para recordar la sesión del usuario. | aB3dE9kLmN... |
| is_active | BOOLEAN | No | | Indica si la cuenta del usuario está activa. Valor por defecto: true. | true |
| created_at | TIMESTAMP | Sí | | Fecha de creación del registro. | 2025-01-05 09:00:00 |
| updated_at | TIMESTAMP | Sí | | Fecha de la última actualización del registro. | 2025-06-01 14:20:00 |
| deleted_at | TIMESTAMP | Sí | | Fecha de eliminación lógica del registro (soft delete). | null |

---

# Tabla: password_reset_tokens
## Descripción
Almacena los tokens temporales generados para el proceso de recuperación de contraseña de los usuarios.
## Relaciones
- No posee relaciones formales con otras tablas (se asocia al correo del usuario de forma referencial).
## Campos
| Campo | Tipo | Nulo | Clave | Descripción | Ejemplo |
|--------|------|------|--------|-------------|---------|
| email | VARCHAR | No | PK | Correo electrónico del usuario que solicita el restablecimiento. | bryan@gmail.com |
| token | VARCHAR | No | | Token único generado para validar la solicitud de cambio de contraseña. | 4f8a2c9d1e... |
| created_at | TIMESTAMP | Sí | | Fecha y hora en que se generó el token. | 2025-06-15 11:45:00 |

---

# Tabla: sessions
## Descripción
Registra las sesiones activas de los usuarios dentro del sistema, incluyendo información técnica del dispositivo utilizado.
## Relaciones
- Pertenece a un User (opcional, puede ser una sesión de invitado).
## Campos
| Campo | Tipo | Nulo | Clave | Descripción | Ejemplo |
|--------|------|------|--------|-------------|---------|
| id | VARCHAR | No | PK | Identificador único de la sesión. | a1b2c3d4e5f6 |
| user_id | BIGINT | Sí | FK | Usuario propietario de la sesión. Referencia a users.id. | 1 |
| ip_address | VARCHAR(45) | Sí | | Dirección IP desde la cual se originó la sesión. | 190.15.23.10 |
| user_agent | TEXT | Sí | | Información del navegador y dispositivo del usuario. | Mozilla/5.0 (Windows NT 10.0...) |
| payload | LONGTEXT | No | | Datos serializados de la sesión. | base64:eyJpdiI6Ii...  |
| last_activity | INTEGER | No | | Marca de tiempo (timestamp UNIX) de la última actividad registrada. | 1719840000 |

---

# Tabla: roles
## Descripción
Define los roles disponibles en el sistema que determinan los permisos y accesos de cada usuario.
## Relaciones
- Puede tener muchos Users.
## Campos
| Campo | Tipo | Nulo | Clave | Descripción | Ejemplo |
|--------|------|------|--------|-------------|---------|
| id | INTEGER | No | PK | Identificador único del rol. | 1 |
| name | VARCHAR(50) | No | UNIQUE | Nombre del rol. | Administrador |
| slug | VARCHAR(60) | No | UNIQUE | Versión amigable del nombre del rol para URLs. | administrador |
| description | VARCHAR(255) | Sí | | Descripción de las funciones del rol. | Rol con acceso total al sistema. |
| created_at | TIMESTAMP | Sí | | Fecha de creación del registro. | 2025-01-01 08:00:00 |
| updated_at | TIMESTAMP | Sí | | Fecha de la última actualización del registro. | 2025-01-01 08:00:00 |
| deleted_at | TIMESTAMP | Sí | | Fecha de eliminación lógica del registro. | null |

---

# Tabla: provinces
## Descripción
Almacena las provincias del Ecuador utilizadas para ubicar geográficamente las obras del patrimonio cultural.
## Relaciones
- Puede tener muchos Cantons.
- Puede tener muchas Obras (artworks).
## Campos
| Campo | Tipo | Nulo | Clave | Descripción | Ejemplo |
|--------|------|------|--------|-------------|---------|
| id | INTEGER | No | PK | Identificador único de la provincia. | 1 |
| name | VARCHAR(100) | No | UNIQUE | Nombre de la provincia. | Esmeraldas |
| slug | VARCHAR(120) | No | UNIQUE | Versión amigable del nombre para URLs. | esmeraldas |
| region | ENUM | No | | Región geográfica a la que pertenece la provincia. Valores: Costa, Sierra, Amazonia, Insular. | Costa |
| description | TEXT | Sí | | Descripción general de la provincia. | Provincia costera reconocida por su diversidad cultural. |
| cover_image | VARCHAR(255) | Sí | | Ruta o URL de la imagen representativa de la provincia. | provinces/esmeraldas.jpg |
| latitude | DECIMAL(10,8) | Sí | | Coordenada de latitud de la provincia. | 0.98920000 |
| longitude | DECIMAL(11,8) | Sí | | Coordenada de longitud de la provincia. | -79.65180000 |
| created_at | TIMESTAMP | Sí | | Fecha de creación del registro. | 2025-01-01 08:00:00 |
| updated_at | TIMESTAMP | Sí | | Fecha de la última actualización del registro. | 2025-01-01 08:00:00 |

---

# Tabla: cantons
## Descripción
Almacena los cantones pertenecientes a cada provincia del Ecuador.
## Relaciones
- Pertenece a una Province.
- Puede tener muchas Parishes.
- Puede tener muchas Obras (artworks).
## Campos
| Campo | Tipo | Nulo | Clave | Descripción | Ejemplo |
|--------|------|------|--------|-------------|---------|
| id | INTEGER | No | PK | Identificador único del cantón. | 1 |
| province_id | BIGINT | No | FK | Provincia a la que pertenece el cantón. Referencia a provinces.id. | 1 |
| name | VARCHAR(100) | No | UNIQUE (con province_id) | Nombre del cantón. | Esmeraldas |
| slug | VARCHAR(120) | No | | Versión amigable del nombre para URLs. | esmeraldas |
| created_at | TIMESTAMP | Sí | | Fecha de creación del registro. | 2025-01-01 08:00:00 |
| updated_at | TIMESTAMP | Sí | | Fecha de la última actualización del registro. | 2025-01-01 08:00:00 |

---

# Tabla: parishes
## Descripción
Almacena las parroquias pertenecientes a cada cantón del Ecuador.
## Relaciones
- Pertenece a un Canton.
- Puede tener muchas Obras (artworks).
## Campos
| Campo | Tipo | Nulo | Clave | Descripción | Ejemplo |
|--------|------|------|--------|-------------|---------|
| id | INTEGER | No | PK | Identificador único de la parroquia. | 1 |
| canton_id | BIGINT | No | FK | Cantón al que pertenece la parroquia. Referencia a cantons.id. | 1 |
| name | VARCHAR(100) | No | UNIQUE (con canton_id) | Nombre de la parroquia. | Vuelta Larga |
| slug | VARCHAR(120) | No | | Versión amigable del nombre para URLs. | vuelta-larga |
| created_at | TIMESTAMP | Sí | | Fecha de creación del registro. | 2025-01-01 08:00:00 |
| updated_at | TIMESTAMP | Sí | | Fecha de la última actualización del registro. | 2025-01-01 08:00:00 |

---

# Tabla: categories
## Descripción
Almacena las categorías utilizadas para clasificar las obras del patrimonio cultural (por ejemplo: pintura, escultura, arquitectura).
## Relaciones
- Puede tener muchas Obras (artworks).
## Campos
| Campo | Tipo | Nulo | Clave | Descripción | Ejemplo |
|--------|------|------|--------|-------------|---------|
| id | INTEGER | No | PK | Identificador único de la categoría. | 1 |
| name | VARCHAR(100) | No | UNIQUE | Nombre de la categoría. | Pintura |
| slug | VARCHAR(120) | No | UNIQUE | Versión amigable del nombre para URLs. | pintura |
| description | TEXT | Sí | | Descripción de la categoría. | Obras artísticas plasmadas sobre lienzo u otra superficie. |
| icon | VARCHAR(255) | Sí | | Ruta o clase del ícono representativo de la categoría. | icons/painting.svg |
| created_at | TIMESTAMP | Sí | | Fecha de creación del registro. | 2025-01-01 08:00:00 |
| updated_at | TIMESTAMP | Sí | | Fecha de la última actualización del registro. | 2025-01-01 08:00:00 |
| deleted_at | TIMESTAMP | Sí | | Fecha de eliminación lógica del registro. | null |

---

# Tabla: artwork_types
## Descripción
Almacena los tipos de obra que permiten clasificar el patrimonio cultural según su naturaleza (por ejemplo: mueble, inmueble, inmaterial).
## Relaciones
- Puede tener muchas Obras (artworks).
## Campos
| Campo | Tipo | Nulo | Clave | Descripción | Ejemplo |
|--------|------|------|--------|-------------|---------|
| id | INTEGER | No | PK | Identificador único del tipo de obra. | 1 |
| name | VARCHAR(100) | No | UNIQUE | Nombre del tipo de obra. | Bien mueble |
| slug | VARCHAR(120) | No | UNIQUE | Versión amigable del nombre para URLs. | bien-mueble |
| description | TEXT | Sí | | Descripción del tipo de obra. | Bienes que pueden trasladarse sin alterar su naturaleza. |
| created_at | TIMESTAMP | Sí | | Fecha de creación del registro. | 2025-01-01 08:00:00 |
| updated_at | TIMESTAMP | Sí | | Fecha de la última actualización del registro. | 2025-01-01 08:00:00 |

---

# Tabla: conservation_statuses
## Descripción
Almacena los posibles estados de conservación en los que se puede encontrar una obra del patrimonio cultural.
## Relaciones
- Puede tener muchas Obras (artworks).
## Campos
| Campo | Tipo | Nulo | Clave | Descripción | Ejemplo |
|--------|------|------|--------|-------------|---------|
| id | INTEGER | No | PK | Identificador único del estado de conservación. | 1 |
| name | VARCHAR(50) | No | UNIQUE | Nombre del estado de conservación. | Bueno |
| slug | VARCHAR(120) | No | UNIQUE | Versión amigable del nombre para URLs. | bueno |
| description | TEXT | Sí | | Descripción del estado de conservación. | La obra se encuentra en buen estado, sin daños visibles. |
| created_at | TIMESTAMP | Sí | | Fecha de creación del registro. | 2025-01-01 08:00:00 |
| updated_at | TIMESTAMP | Sí | | Fecha de la última actualización del registro. | 2025-01-01 08:00:00 |

---

# Tabla: artists
## Descripción
Almacena la información de los artistas o autores relacionados con las obras del patrimonio cultural.
## Relaciones
- Puede estar asociado a muchas Obras (artworks), a través de la tabla artwork_artist.
## Campos
| Campo | Tipo | Nulo | Clave | Descripción | Ejemplo |
|--------|------|------|--------|-------------|---------|
| id | INTEGER | No | PK | Identificador único del artista. | 1 |
| first_name | VARCHAR(100) | No | | Nombres del artista. | Oswaldo |
| last_name | VARCHAR(100) | Sí | | Apellidos del artista. | Guayasamín |
| full_name | VARCHAR(200) | No | | Nombre completo del artista. | Oswaldo Guayasamín |
| slug | VARCHAR(255) | No | UNIQUE | Versión amigable del nombre completo para URLs. | oswaldo-guayasamin |
| birth_date | DATE | Sí | | Fecha de nacimiento del artista. | 1919-07-06 |
| birth_place | VARCHAR(150) | Sí | | Lugar de nacimiento del artista. | Quito, Ecuador |
| death_date | DATE | Sí | | Fecha de fallecimiento del artista, si aplica. | 1999-03-10 |
| is_deceased | BOOLEAN | No | | Indica si el artista ha fallecido. Valor por defecto: false. | true |
| nationality | VARCHAR(100) | Sí | | Nacionalidad del artista. | Ecuatoriana |
| biography | LONGTEXT | Sí | | Reseña biográfica extensa del artista. | Pintor y escultor considerado uno de los más importantes de Latinoamérica. |
| profile_image | VARCHAR(255) | Sí | | Ruta o URL de la fotografía del artista. | artists/guayasamin.jpg |
| website | VARCHAR(255) | Sí | | Sitio web oficial o de referencia del artista. | https://guayasamin.org |
| created_at | TIMESTAMP | Sí | | Fecha de creación del registro. | 2025-01-01 08:00:00 |
| updated_at | TIMESTAMP | Sí | | Fecha de la última actualización del registro. | 2025-01-01 08:00:00 |
| deleted_at | TIMESTAMP | Sí | | Fecha de eliminación lógica del registro. | null |

---

# Tabla: artworks
## Descripción
Tabla principal del sistema. Almacena la información detallada de cada obra registrada dentro del patrimonio cultural del Ecuador.
## Relaciones
- Pertenece a una Category.
- Pertenece a un Conservation Status (opcional).
- Pertenece a un Artwork Type.
- Pertenece a una Province.
- Pertenece a un Canton.
- Pertenece a una Parish (opcional).
- Fue creada por un User (created_by).
- Fue actualizada por un User (updated_by).
- Fue publicada por un User (published_by).
- Puede estar asociada a muchos Artists, a través de artwork_artist.
- Puede tener muchas Imágenes (artwork_images).
- Puede tener muchos Videos (artwork_videos).
- Puede tener muchos Documentos (artwork_documents).
- Puede estar asociada a muchos Tags, a través de artwork_tag.
- Puede tener muchos Comentarios.
- Puede tener muchos Favoritos.
- Puede tener muchas Valoraciones (ratings).
- Puede tener muchas Fuentes bibliográficas (artwork_sources).
- Puede tener muchos Eventos de restauración (restoration_events).
- Puede tener muchas Vistas registradas (artwork_views).
## Campos
| Campo | Tipo | Nulo | Clave | Descripción | Ejemplo |
|--------|------|------|--------|-------------|---------|
| id | INTEGER | No | PK | Identificador único de la obra. | 1 |
| category_id | BIGINT | No | FK | Categoría de la obra. Referencia a categories.id. | 1 |
| conservation_status_id | BIGINT | Sí | FK | Estado de conservación de la obra. Referencia a conservation_statuses.id. | 2 |
| artwork_type_id | BIGINT | No | FK | Tipo de la obra. Referencia a artwork_types.id. | 1 |
| province_id | BIGINT | No | FK | Provincia donde se ubica la obra. Referencia a provinces.id. | 1 |
| canton_id | BIGINT | No | FK | Cantón donde se ubica la obra. Referencia a cantons.id. | 1 |
| parish_id | BIGINT | Sí | FK | Parroquia donde se ubica la obra. Referencia a parishes.id. | 3 |
| created_by | BIGINT | Sí | FK | Usuario que creó el registro de la obra. Referencia a users.id. | 1 |
| updated_by | BIGINT | Sí | FK | Usuario que realizó la última actualización de la obra. Referencia a users.id. | 2 |
| reading_time | SMALLINT | Sí | | Tiempo estimado de lectura del contenido de la obra, en minutos. | 5 |
| code | VARCHAR(30) | No | UNIQUE | Código único de identificación patrimonial de la obra. | PAT-ESM-0001 |
| title | VARCHAR(255) | No | | Título de la obra. | La Malinche Ecuatoriana |
| seo_title | VARCHAR(255) | Sí | | Título optimizado para motores de búsqueda (SEO). | La Malinche Ecuatoriana - Patrimonio Cultural |
| slug | VARCHAR(255) | No | UNIQUE | Versión amigable del título para URLs. | la-malinche-ecuatoriana |
| short_description | TEXT | Sí | | Descripción breve o resumen de la obra. | Pintura mural que retrata la fusión cultural del Ecuador. |
| description | LONGTEXT | No | | Descripción completa y detallada de la obra. | Obra realizada en 1980, ubicada en el centro histórico... |
| language | VARCHAR(10) | No | | Idioma en el que está redactado el contenido. Valor por defecto: 'es'. | es |
| seo_description | VARCHAR(255) | Sí | | Descripción optimizada para motores de búsqueda (SEO). | Conoce la historia detrás de esta obra patrimonial. |
| historical_context | LONGTEXT | Sí | | Contexto histórico relacionado con la creación de la obra. | Realizada durante el auge del movimiento indigenista... |
| creation_year | YEAR | Sí | | Año en que fue creada la obra. | 1980 |
| dimensions | VARCHAR(100) | Sí | | Dimensiones físicas de la obra. | 2.5m x 1.8m |
| weight | DECIMAL(10,2) | Sí | | Peso de la obra, en kilogramos. | 45.50 |
| address | VARCHAR(255) | Sí | | Dirección física donde se encuentra la obra. | Av. Bolívar y Sucre, Esmeraldas |
| estimated_value | DECIMAL(12,2) | Sí | | Valor económico estimado de la obra. | 15000.00 |
| accessibility_notes | TEXT | Sí | | Notas sobre accesibilidad para visitar o apreciar la obra. | Acceso disponible para personas con movilidad reducida. |
| latitude | DECIMAL(10,8) | Sí | | Coordenada de latitud de la ubicación de la obra. | 0.98920000 |
| longitude | DECIMAL(11,8) | Sí | | Coordenada de longitud de la ubicación de la obra. | -79.65180000 |
| visit_count | INT | No | | Número de visitas registradas para la obra. Valor por defecto: 0. | 152 |
| average_rating | DECIMAL(3,2) | No | | Calificación promedio obtenida por la obra. Valor por defecto: 0.00. | 4.50 |
| is_featured | BOOLEAN | No | | Indica si la obra es destacada. Valor por defecto: false. | true |
| status | ENUM | No | | Estado de publicación de la obra. Valores: borrador, pendiente, publicado, archivado. | publicado |
| published_by | BIGINT | Sí | FK | Usuario que publicó la obra. Referencia a users.id. | 1 |
| published_at | TIMESTAMP | Sí | | Fecha y hora en que se publicó la obra. | 2025-02-15 10:00:00 |
| created_at | TIMESTAMP | Sí | | Fecha de creación del registro. | 2025-01-01 08:00:00 |
| updated_at | TIMESTAMP | Sí | | Fecha de la última actualización del registro. | 2025-02-15 10:00:00 |
| deleted_at | TIMESTAMP | Sí | | Fecha de eliminación lógica del registro. | null |

---

# Tabla: artwork_artist
## Descripción
Tabla intermedia que relaciona las obras con los artistas que participaron en su creación (relación muchos a muchos).
## Relaciones
- Pertenece a una Artwork.
- Pertenece a un Artist.
## Campos
| Campo | Tipo | Nulo | Clave | Descripción | Ejemplo |
|--------|------|------|--------|-------------|---------|
| artwork_id | BIGINT | No | PK, FK | Obra relacionada. Referencia a artworks.id. | 1 |
| artist_id | BIGINT | No | PK, FK | Artista relacionado. Referencia a artists.id. | 1 |

---

# Tabla: artwork_images
## Descripción
Almacena las imágenes asociadas a cada obra del patrimonio cultural.
## Relaciones
- Pertenece a una Artwork.
## Campos
| Campo | Tipo | Nulo | Clave | Descripción | Ejemplo |
|--------|------|------|--------|-------------|---------|
| id | INTEGER | No | PK | Identificador único de la imagen. | 1 |
| artwork_id | BIGINT | No | FK | Obra a la que pertenece la imagen. Referencia a artworks.id. | 1 |
| photographer | VARCHAR(150) | Sí | | Nombre del fotógrafo que capturó la imagen. | Juan Pérez |
| image_path | VARCHAR(255) | No | | Ruta o URL donde se almacena la imagen. | artworks/images/malinche_01.jpg |
| caption | VARCHAR(255) | Sí | | Leyenda o texto descriptivo de la imagen. | Vista frontal de la obra. |
| alt_text | VARCHAR(255) | Sí | | Texto alternativo de la imagen, utilizado para accesibilidad y SEO. | Mural La Malinche Ecuatoriana, vista frontal |
| file_size | BIGINT | Sí | | Tamaño del archivo de la imagen, en bytes. | 2048576 |
| width | INTEGER | Sí | | Ancho de la imagen, en píxeles. | 1920 |
| height | INTEGER | Sí | | Alto de la imagen, en píxeles. | 1080 |
| mime_type | VARCHAR(100) | Sí | | Tipo MIME del archivo de la imagen. | image/jpeg |
| image_hash | VARCHAR(64) | Sí | | Hash único de la imagen, utilizado para evitar duplicados. | a1b2c3d4e5f6... |
| display_order | SMALLINT | No | | Orden de visualización de la imagen dentro de la galería de la obra. Valor por defecto: 1. | 1 |
| is_cover | BOOLEAN | No | | Indica si la imagen es la portada de la obra. Valor por defecto: false. | true |
| created_at | TIMESTAMP | Sí | | Fecha de creación del registro. | 2025-01-01 08:00:00 |
| updated_at | TIMESTAMP | Sí | | Fecha de la última actualización del registro. | 2025-01-01 08:00:00 |

---

# Tabla: artwork_videos
## Descripción
Almacena los videos relacionados con cada obra del patrimonio cultural.
## Relaciones
- Pertenece a una Artwork.
## Campos
| Campo | Tipo | Nulo | Clave | Descripción | Ejemplo |
|--------|------|------|--------|-------------|---------|
| id | INTEGER | No | PK | Identificador único del video. | 1 |
| artwork_id | BIGINT | No | FK | Obra a la que pertenece el video. Referencia a artworks.id. | 1 |
| title | VARCHAR(255) | No | | Título del video. | Historia de La Malinche Ecuatoriana |
| video_url | VARCHAR(255) | No | | URL donde se aloja el video. | https://youtube.com/watch?v=abc123 |
| thumbnail | VARCHAR(255) | Sí | | Ruta o URL de la miniatura del video. | videos/thumbnails/malinche.jpg |
| duration | TIME | Sí | | Duración del video. | 00:05:32 |
| provider | VARCHAR(20) | Sí | | Plataforma o proveedor donde está alojado el video. | YouTube |
| created_at | TIMESTAMP | Sí | | Fecha de creación del registro. | 2025-01-01 08:00:00 |
| updated_at | TIMESTAMP | Sí | | Fecha de la última actualización del registro. | 2025-01-01 08:00:00 |

---

# Tabla: artwork_documents
## Descripción
Almacena los documentos digitales relacionados con cada obra, como fichas técnicas o estudios patrimoniales.
## Relaciones
- Pertenece a una Artwork.
## Campos
| Campo | Tipo | Nulo | Clave | Descripción | Ejemplo |
|--------|------|------|--------|-------------|---------|
| id | INTEGER | No | PK | Identificador único del documento. | 1 |
| artwork_id | BIGINT | No | FK | Obra a la que pertenece el documento. Referencia a artworks.id. | 1 |
| title | VARCHAR(255) | No | | Título del documento. | Ficha técnica de restauración |
| file_name | VARCHAR(255) | No | | Nombre del archivo del documento. | ficha_tecnica_malinche.pdf |
| description | TEXT | Sí | | Descripción del contenido del documento. | Informe técnico sobre el proceso de restauración de la obra. |
| file_path | VARCHAR(255) | No | | Ruta o URL donde se almacena el documento. | documents/ficha_tecnica_malinche.pdf |
| mime_type | VARCHAR(100) | No | | Tipo MIME del archivo del documento. | application/pdf |
| file_size | BIGINT | No | | Tamaño del archivo del documento, en bytes. | 512000 |
| download_count | INT | No | | Número de veces que el documento ha sido descargado. Valor por defecto: 0. | 34 |
| created_at | TIMESTAMP | Sí | | Fecha de creación del registro. | 2025-01-01 08:00:00 |
| updated_at | TIMESTAMP | Sí | | Fecha de la última actualización del registro. | 2025-01-01 08:00:00 |

---

# Tabla: tags
## Descripción
Almacena las etiquetas utilizadas para clasificar o facilitar la búsqueda de obras dentro del sistema.
## Relaciones
- Puede estar asociada a muchas Obras (artworks), a través de artwork_tag.
## Campos
| Campo | Tipo | Nulo | Clave | Descripción | Ejemplo |
|--------|------|------|--------|-------------|---------|
| id | INTEGER | No | PK | Identificador único de la etiqueta. | 1 |
| name | VARCHAR(100) | No | UNIQUE | Nombre de la etiqueta. | Arte Colonial |
| slug | VARCHAR(120) | No | UNIQUE | Versión amigable del nombre para URLs. | arte-colonial |
| created_at | TIMESTAMP | Sí | | Fecha de creación del registro. | 2025-01-01 08:00:00 |
| updated_at | TIMESTAMP | Sí | | Fecha de la última actualización del registro. | 2025-01-01 08:00:00 |
| deleted_at | TIMESTAMP | Sí | | Fecha de eliminación lógica del registro. | null |

---

# Tabla: artwork_tag
## Descripción
Tabla intermedia que relaciona las obras con las etiquetas asignadas (relación muchos a muchos).
## Relaciones
- Pertenece a una Artwork.
- Pertenece a un Tag.
## Campos
| Campo | Tipo | Nulo | Clave | Descripción | Ejemplo |
|--------|------|------|--------|-------------|---------|
| artwork_id | BIGINT | No | PK, FK | Obra relacionada. Referencia a artworks.id. | 1 |
| tag_id | BIGINT | No | PK, FK | Etiqueta relacionada. Referencia a tags.id. | 1 |

---

# Tabla: comments
## Descripción
Almacena los comentarios realizados por los usuarios sobre las obras del patrimonio cultural, permitiendo respuestas anidadas.
## Relaciones
- Pertenece a una Artwork.
- Pertenece a un User (opcional).
- Puede pertenecer a un Comentario padre (parent_id), para respuestas anidadas.
- Puede tener muchos Comentarios hijos (respuestas).
## Campos
| Campo | Tipo | Nulo | Clave | Descripción | Ejemplo |
|--------|------|------|--------|-------------|---------|
| id | INTEGER | No | PK | Identificador único del comentario. | 1 |
| artwork_id | BIGINT | No | FK | Obra a la que pertenece el comentario. Referencia a artworks.id. | 1 |
| user_id | BIGINT | Sí | FK | Usuario que realizó el comentario. Referencia a users.id. | 3 |
| parent_id | BIGINT | Sí | FK | Comentario padre, en caso de ser una respuesta. Referencia a comments.id. | 1 |
| content | TEXT | No | | Contenido textual del comentario. | Excelente obra, muy representativa de nuestra cultura. |
| is_approved | BOOLEAN | No | | Indica si el comentario ha sido aprobado para su publicación. Valor por defecto: true. | true |
| created_at | TIMESTAMP | Sí | | Fecha de creación del registro. | 2025-03-01 09:15:00 |
| updated_at | TIMESTAMP | Sí | | Fecha de la última actualización del registro. | 2025-03-01 09:15:00 |
| deleted_at | TIMESTAMP | Sí | | Fecha de eliminación lógica del registro. | null |

---

# Tabla: favorites
## Descripción
Almacena las obras marcadas como favoritas por cada usuario.
## Relaciones
- Pertenece a un User.
- Pertenece a una Artwork.
## Campos
| Campo | Tipo | Nulo | Clave | Descripción | Ejemplo |
|--------|------|------|--------|-------------|---------|
| user_id | BIGINT | No | PK, FK | Usuario que marcó la obra como favorita. Referencia a users.id. | 1 |
| artwork_id | BIGINT | No | PK, FK | Obra marcada como favorita. Referencia a artworks.id. | 1 |
| created_at | TIMESTAMP | Sí | | Fecha en que se registró como favorito. | 2025-03-05 12:00:00 |

---

# Tabla: ratings
## Descripción
Almacena las valoraciones (calificaciones y reseñas) que los usuarios realizan sobre las obras del patrimonio cultural.
## Relaciones
- Pertenece a una Artwork.
- Pertenece a un User.
## Campos
| Campo | Tipo | Nulo | Clave | Descripción | Ejemplo |
|--------|------|------|--------|-------------|---------|
| id | INTEGER | No | PK | Identificador único de la valoración. | 1 |
| artwork_id | BIGINT | No | FK | Obra valorada. Referencia a artworks.id. | 1 |
| user_id | BIGINT | No | FK | Usuario que realizó la valoración. Referencia a users.id. | 3 |
| rating | TINYINT | No | | Calificación otorgada a la obra, en una escala numérica. | 5 |
| review | TEXT | Sí | | Comentario o reseña asociada a la valoración. | Una obra impresionante que refleja nuestra identidad cultural. |
| created_at | TIMESTAMP | Sí | | Fecha de creación del registro. | 2025-03-10 10:00:00 |
| updated_at | TIMESTAMP | Sí | | Fecha de la última actualización del registro. | 2025-03-10 10:00:00 |

---

# Tabla: artwork_sources
## Descripción
Almacena las fuentes bibliográficas o referencias documentales utilizadas para respaldar la información de una obra.
## Relaciones
- Pertenece a una Artwork.
## Campos
| Campo | Tipo | Nulo | Clave | Descripción | Ejemplo |
|--------|------|------|--------|-------------|---------|
| id | INTEGER | No | PK | Identificador único de la fuente. | 1 |
| artwork_id | BIGINT | No | FK | Obra a la que pertenece la fuente. Referencia a artworks.id. | 1 |
| title | VARCHAR(255) | No | | Título de la fuente bibliográfica. | Historia del Arte Ecuatoriano |
| author | VARCHAR(255) | Sí | | Autor de la fuente. | María Fernández |
| isbn | VARCHAR(20) | Sí | | Código ISBN de la fuente, si aplica. | 978-9942-01-234-5 |
| source_type | ENUM | No | | Tipo de fuente bibliográfica. Valores: libro, sitio web, articulo, revista, periodico, otros. | libro |
| url | VARCHAR(500) | Sí | | Enlace web de la fuente, si aplica. | https://ejemplo.com/articulo |
| published_at | DATE | Sí | | Fecha de publicación de la fuente. | 2018-05-20 |
| created_at | TIMESTAMP | Sí | | Fecha de creación del registro. | 2025-01-01 08:00:00 |
| updated_at | TIMESTAMP | Sí | | Fecha de la última actualización del registro. | 2025-01-01 08:00:00 |

---

# Tabla: restoration_events
## Descripción
Almacena el historial de eventos de restauración realizados sobre una obra del patrimonio cultural.
## Relaciones
- Pertenece a una Artwork.
## Campos
| Campo | Tipo | Nulo | Clave | Descripción | Ejemplo |
|--------|------|------|--------|-------------|---------|
| id | INTEGER | No | PK | Identificador único del evento de restauración. | 1 |
| artwork_id | BIGINT | No | FK | Obra que fue objeto de la restauración. Referencia a artworks.id. | 1 |
| restoration_date | DATE | No | | Fecha en la que se realizó la restauración. | 2020-08-15 |
| organization | VARCHAR(255) | Sí | | Organización o entidad encargada de la restauración. | Instituto Nacional de Patrimonio Cultural |
| description | LONGTEXT | No | | Descripción detallada del proceso de restauración realizado. | Se realizó limpieza superficial y fijación de pigmentos. |
| created_at | TIMESTAMP | Sí | | Fecha de creación del registro. | 2025-01-01 08:00:00 |
| updated_at | TIMESTAMP | Sí | | Fecha de la última actualización del registro. | 2025-01-01 08:00:00 |

---

# Tabla: artwork_views
## Descripción
Registra cada visita o visualización realizada sobre una obra, con fines estadísticos y de auditoría.
## Relaciones
- Pertenece a una Artwork.
- Pertenece a un User (opcional, puede ser una visita anónima).
## Campos
| Campo | Tipo | Nulo | Clave | Descripción | Ejemplo |
|--------|------|------|--------|-------------|---------|
| id | INTEGER | No | PK | Identificador único de la visita. | 1 |
| artwork_id | BIGINT | No | FK | Obra que fue visualizada. Referencia a artworks.id. | 1 |
| user_id | BIGINT | Sí | FK | Usuario que realizó la visita, si estaba autenticado. Referencia a users.id. | 3 |
| ip_address | VARCHAR(45) | Sí | | Dirección IP desde la cual se realizó la visita. | 190.15.23.10 |
| user_agent | TEXT | Sí | | Información del navegador y dispositivo utilizado en la visita. | Mozilla/5.0 (Windows NT 10.0...) |
| created_at | TIMESTAMP | Sí | | Fecha y hora en que se registró la visita. Valor por defecto: CURRENT_TIMESTAMP. | 2025-04-01 15:30:00 |

---

# Tabla: audit_logs
## Descripción
Almacena el registro de auditoría de las acciones realizadas por los usuarios sobre los distintos módulos del sistema, con fines de trazabilidad y seguridad.
## Relaciones
- Pertenece a un User (opcional).
## Campos
| Campo | Tipo | Nulo | Clave | Descripción | Ejemplo |
|--------|------|------|--------|-------------|---------|
| id | INTEGER | No | PK | Identificador único del registro de auditoría. | 1 |
| user_id | BIGINT | Sí | FK | Usuario que realizó la acción registrada. Referencia a users.id. | 1 |
| action | VARCHAR(50) | No | | Tipo de acción realizada (crear, actualizar, eliminar, etc.). | actualizar |
| table_name | VARCHAR(100) | No | | Nombre de la tabla afectada por la acción. | artworks |
| record_id | BIGINT | No | | Identificador del registro afectado en la tabla correspondiente. | 15 |
| old_values | JSON | Sí | | Valores del registro antes de la modificación. | {"status": "borrador"} |
| new_values | JSON | Sí | | Valores del registro después de la modificación. | {"status": "publicado"} |
| description | TEXT | Sí | | Descripción adicional sobre la acción realizada. | Se cambió el estado de la obra a publicado. |
| ip_address | VARCHAR(45) | Sí | | Dirección IP desde la cual se realizó la acción. | 190.15.23.10 |
| user_agent | TEXT | Sí | | Información del navegador y dispositivo desde el cual se realizó la acción. | Mozilla/5.0 (Windows NT 10.0...) |
| created_at | TIMESTAMP | Sí | | Fecha y hora en que se registró la acción. | 2025-04-01 15:30:00 |
