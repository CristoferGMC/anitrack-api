
# Anitrack API

API RESTful desarrollada en Laravel para la gestión y consulta de animes y mangas, integrando autenticación JWT y consumo de datos desde AniList.

## Requisitos

- **PHP** >= 8.2
- **MySQL**
- **Composer**
- **Node.js y npm** (opcional para assets)
- **Extensiones:** Laravel Sanctum, JWT Auth

## Instalación

1. Clona el repositorio y entra a la carpeta del proyecto.
2. Instala dependencias backend:
	```
	composer install
	```
3. Copia el archivo `.env.example` a `.env` y configura tu base de datos y llaves JWT.
4. Ejecuta las migraciones y seeders:
	```
	php artisan migrate --seed
	```
5. Genera la clave JWT:
	```
	php artisan jwt:secret
	```
6. Inicia el servidor:
	```
	php artisan serve
	```

## Endpoints principales

- **Autenticación:**
  - `POST /api/auth/register` — Registro de usuario
  - `POST /api/auth/login` — Login y obtención de token JWT
  - `POST /api/auth/logout` — Cierre de sesión
  - `POST /api/auth/refresh` — Refrescar token
  - `POST /api/auth/me` — Información del usuario autenticado

- **Animes:**
  - `GET /api/animes` — Listado de animes
  - `GET /api/animes/top` — Top 100 animes populares (AniList)
  - `GET /api/animes/{id}` — Detalle de anime
  - `POST /api/animes` — Crear anime (requiere autenticación)
  - `PUT /api/animes/{id}` — Actualizar anime (requiere autenticación)
  - `DELETE /api/animes/{id}` — Eliminar anime (requiere autenticación)

- **Mangas:**
  - `GET /api/mangas` — Listado de mangas
  - `GET /api/mangas/top` — Top 100 mangas populares (AniList)
  - `GET /api/mangas/{id}` — Detalle de manga
  - `POST /api/mangas` — Crear manga (requiere autenticación)
  - `PUT /api/mangas/{id}` — Actualizar manga (requiere autenticación)
  - `DELETE /api/mangas/{id}` — Eliminar manga (requiere autenticación)

## Seguridad

- Autenticación basada en JWT.
- Rutas protegidas para operaciones de escritura.

## Integraciones

- Consumo de la API pública de AniList para obtener información actualizada de animes y mangas.
