# Sistema Nacional de Patrimonio Cultural del Ecuador

Aplicación web desarrollada con Laravel para registrar, administrar y consultar bienes patrimoniales, artistas, categorías, provincias, cantones, parroquias y obras culturales del Ecuador.

## ¿De qué trata el proyecto?

Este proyecto tiene como objetivo centralizar la información cultural del país en una plataforma administrativa y pública que permita:

- gestionar datos de provincias, cantones y parroquias;
- registrar artistas y categorías culturales;
- crear y administrar obras patrimoniales;
- asociar imágenes, videos, coordenadas geográficas y ubicaciones;
- consultar el contenido desde un portal público con búsquedas y filtros;
- mantener un flujo de administración con permisos y roles de usuario.

La aplicación está pensada tanto para uso interno de administración como para exhibición pública de información patrimonial.

## Funcionalidades principales

- Panel administrativo con AdminLTE
- Gestión de usuarios y roles
- CRUD de artistas, categorías, provincias, cantones y parroquias
- CRUD de obras de patrimonio cultural
- Subida de múltiples imágenes por obra
- Asociación de videos
- Geolocalización con coordenadas de latitud y longitud
- Portal público con búsqueda y visualización de obras
- Sistema de comentarios y calificaciones
- Dashboard personalizado

## Stack tecnológico

- PHP 8.3
- Laravel 13
- Composer
- Node.js + npm
- MySQL (mediante Laravel Sail en Docker)
- Vite
- AdminLTE
- Livewire

## Requisitos previos

Antes de instalar el proyecto necesitas tener instalado:

- Git
- Composer 2
- Node.js 18+ y npm
- Docker Desktop o Docker Engine con Docker Compose
- PHP 8.3 (si no usas Sail)

## Instalación

### Opción recomendada: Laravel Sail + Docker

1. Clona el repositorio:

```bash
git clone <url-del-repositorio>
cd information-projects-provincie-ecuador
```

2. Copia el archivo de entorno:

```bash
cp .env.example .env
```

3. Levanta los contenedores de Sail:

```bash
./vendor/bin/sail up -d
```

4. Instala dependencias de PHP y JavaScript:

```bash
./vendor/bin/sail composer install
./vendor/bin/sail npm install
```

5. Genera la clave de la aplicación:

```bash
./vendor/bin/sail artisan key:generate
```

6. Ejecuta migraciones y seeders:

```bash
./vendor/bin/sail artisan migrate --seed
```

7. Compila los assets frontend:

```bash
./vendor/bin/sail npm run build
```

8. Abre la aplicación en tu navegador:

```text
http://localhost:8080
```

### Ejecución en entorno local sin Sail

Si prefieres ejecutar la app directamente en tu máquina:

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run build
php artisan serve
```

## Variables de entorno

El proyecto incluye un archivo `.env.example` con una configuración base. Ajusta los valores según tu entorno local, especialmente:

- `APP_URL`
- `DB_CONNECTION`
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`
- `APP_PORT`

## Comandos útiles

```bash
./vendor/bin/sail artisan test
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed
./vendor/bin/sail npm run dev
```

## Estructura principal

- `app/` — lógica de la aplicación
- `config/` — configuraciones de Laravel
- `database/migrations/` — migraciones
- `database/seeders/` — seeders iniciales
- `resources/views/` — vistas Blade
- `routes/` — rutas de la aplicación
- `public/` — archivos públicos y assets compilados
- `tests/` — pruebas automatizadas

## Licencia

Este proyecto está bajo la licencia MIT.

