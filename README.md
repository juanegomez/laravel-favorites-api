# API de Favoritos con Laravel

Una API RESTful para gestionar favoritos de usuarios construida con Laravel y Laravel Sanctum para autenticación.

## Características

- Registro y autenticación de usuarios con Laravel Sanctum
- Autenticación basada en JWT
- Restablecimiento de contraseña con tokens seguros
- Operaciones CRUD para favoritos de usuarios
- Filtrado y paginación de favoritos
- Soporte CORS para integración con frontend

## Requisitos Previos

- PHP >= 8.3 (Recomendado versión 8.3.6 o superior)
  - Extensión SQLite3 para PHP (necesaria para migraciones y operaciones con SQLite)
- Composer (Recomendado versión 2.8.11 o superior)
- Laravel Framework 12.28.0
- SQLite (recomendado para desarrollo local)

## Instalación

### Desarrollo Local

1. Clona el repositorio:
   ```bash
   git clone [https://github.com/juanegomez/laravel-favorites-api.git]
   cd laravel-favorites-api
   ```

2. Instala las dependencias de PHP y la extensión SQLite3:
   ```bash
   # En Ubuntu/Debian
   sudo apt-get install php-sqlite3
   
   # En macOS (usando Homebrew)
   brew install php-sqlite
   
   # En Windows (usando XAMPP/WAMP, habilita la extensión en php.ini)
   ; Busca y descomenta esta línea en tu php.ini
   extension=sqlite3
   
   # Luego instala las dependencias de Composer:
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

8. Inicia el servidor de desarrollo:
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

#### Registro de Usuario

```http
POST /api/register

{
    "name": "Nombre de Usuario",
    "email": "usuario@ejemplo.com",
    "password": "Contraseña123!",
    "password_confirmation": "Contraseña123!"
}
```

#### Inicio de Sesión

```http
POST /api/login

{
    "email": "usuario@ejemplo.com",
    "password": "Contraseña123!"
}
```

#### Solicitar Restablecimiento de Contraseña

```http
POST /api/forgot-password

{
    "email": "usuario@ejemplo.com"
}
```

#### Restablecer Contraseña

```http
POST /api/reset-password

{
    "email": "usuario@ejemplo.com",
    "token": "token_recibido_por_email",
    "password": "NuevaContraseña123!",
    "password_confirmation": "NuevaContraseña123!"
}
```

**Nota sobre la contraseña:** La contraseña debe tener al menos 8 caracteres y contener al menos:
- Una letra mayúscula
- Una letra minúscula
- Un número
- Un carácter especial (ej: @$!%*#?&)

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
