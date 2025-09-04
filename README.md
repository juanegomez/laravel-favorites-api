# API de Favoritos con Laravel

Una API RESTful para gestionar favoritos de usuarios construida con Laravel y Laravel Sanctum para autenticación.

## Características

- Registro y autenticación de usuarios con Laravel Sanctum
- Autenticación basada en JWT
- Operaciones CRUD para favoritos de usuarios
- Filtrado y paginación de favoritos
- Soporte CORS para integración con frontend

## Requisitos Previos

- PHP >= 8.2
- Composer
- SQLite (recomendado para desarrollo local)

## Instalación

### Desarrollo Local

1. Clona el repositorio:
   ```bash
   git clone [https://github.com/juanegomez/laravel-favorites-api.git]
   cd laravel-favorites-api
   ```

2. Instala las dependencias de PHP:
   ```bash
   composer install
   ```

3. Instala las dependencias de NPM (si es necesario):
   ```bash
   npm install
   ```

4. Copia el archivo de entorno:
   ```bash
   cp .env.example .env
   ```

5. Genera la clave de la aplicación:
   ```bash
   php artisan key:generate
   ```

6. Configura SQLite para desarrollo local:
   ```bash
   touch database/database.sqlite
   ```

   Luego, en tu archivo `.env` configura:
   ```env
   DB_CONNECTION=sqlite
   ```

7. Ejecuta las migraciones y seeders:
   ```bash
   php artisan migrate --seed
   ```

8. Genera la clave secreta JWT:
   ```bash
   php artisan jwt:secret
   ```

9. Inicia el servidor de desarrollo:
   ```bash
   php artisan serve
   ```

## Variables de Entorno

Variables de entorno requeridas en `.env`:

```env
APP_NAME="API de Favoritos Laravel"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Configuración para SQLite (recomendado para desarrollo)
DB_CONNECTION=sqlite
DB_DATABASE=/ruta/completa/a/tu/proyecto/database/database.sqlite

# Configuración opcional para MySQL/PostgreSQL
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=favorites_db
# DB_USERNAME=root
# DB_PASSWORD=PaSSw0rd123@

JWT_SECRET=tu_clave_secreta_aqui
JWT_TTL=60

SANCTUM_STATEFUL_DOMAINS=localhost:3000
SESSION_DOMAIN=localhost
```

## Endpoints de la API

### Autenticación

- `POST /api/register` - Registrar un nuevo usuario
- `POST /api/login` - Iniciar sesión
- `POST /api/logout` - Cerrar sesión (requiere autenticación)

### Favoritos

- `GET /api/favorite` - Obtener todos los favoritos (con paginación)
- `POST /api/favorite` - Crear un nuevo favorito
- `GET /api/favorite/{id}` - Obtener un favorito específico
- `PUT|PATCH /api/favorite/{id}` - Actualizar un favorito
- `DELETE /api/favorite/{id}` - Eliminar un favorito
- `GET /api/favorites/ids` - Obtener todos los IDs de API favoritos del usuario autenticado

## Credenciales de Usuario de Prueba

Puedes usar las siguientes credenciales de prueba (se crean automáticamente con el seeder):

- **Email:** test@example.com
- **Contraseña:** Password123@

O registra un nuevo usuario a través del endpoint `/api/register`.

## Notas de Desarrollo

- **SQLite**: Se recomienda usar SQLite para desarrollo local por su simplicidad.
- **Migraciones**: Si necesitas reiniciar la base de datos, puedes usar:
  ```bash
  php artisan migrate:fresh --seed
  ```
- **Logs**: Los logs de la aplicación se encuentran en `storage/logs/laravel.log`
