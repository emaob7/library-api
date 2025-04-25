# 📚 Biblioteca API - Documentación Técnica

## 🔍 Información General
**Versión:** 1.0.0  
**Tecnologías:**  
- Laravel 12
- PHP 8.4
- MySQL 8.0
- Sanctum (Autenticación JWT)

API RESTful para la gestión de una biblioteca en línea con autenticación JWT, desarrollada con Laravel 12 y PHP 8.4.

## 📌 Características principales

✅ Autenticación JWT (Registro, Login, Logout)

✅ CRUD completo para Autores

✅ CRUD completo para Libros

✅ Relación Autor-Libro

✅ Validación de datos

✅ Manejo de errores estandarizado

✅ Paginación de resultados

✅ Pruebas automatizadas


## 🚀 Instalación Rápida

```bash
# Clonar repositorio
git clone https://github.com/emaob7/library-api.git
cd library-api

# Instalar dependencias
composer install

# Configurar entorno
cp .env.example .env
php artisan key:generate

# Configurar base de datos (editar .env)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=biblioteca
DB_USERNAME=root
DB_PASSWORD=

# Ejecutar migraciones
php artisan migrate --seed

# Iniciar servidor
php artisan serve

```
## 🌐 Endpoints de la API

### Autenticación

| Método | Endpoint                     | Descripción                |
|--------|------------------------------|----------------------------|
| POST   | `/api/v1/auth/register`      | Registrar nuevo usuario    |
| POST   | `/api/v1/auth/login`         | Iniciar sesión            |
| POST   | `/api/v1/auth/logout`        | Cerrar sesión             |

### Autores

| Método | Endpoint                     | Descripción                |
|--------|------------------------------|----------------------------|
| GET    | `/api/v1/authors`            | Listar autores            |
| POST   | `/api/v1/authors`            | Crear autor               |
| GET    | `/api/v1/authors/{id}`       | Ver autor                 |
| PUT    | `/api/v1/authors/{id}`       | Actualizar autor          |
| DELETE | `/api/v1/authors/{id}`       | Eliminar autor            |

### Libros

| Método | Endpoint                     | Descripción                |
|--------|------------------------------|----------------------------|
| GET    | `/api/v1/books`              | Listar libros             |
| POST   | `/api/v1/books`              | Crear libro               |
| GET    | `/api/v1/books/{id}`         | Ver libro                 |
| PUT    | `/api/v1/books/{id}`         | Actualizar libro          |
| DELETE | `/api/v1/books/{id}`         | Eliminar libro            |


## 🔐 Autenticación

Para acceder a los endpoints protegidos, incluye el token JWT en el header:

```http
Authorization: Bearer [tu_token]
```
## 📝 Ejemplos de uso
- Registro de usuario
```http
POST /api/v1/auth/register
Content-Type: application/json

{
    "name": "Juan Perez",
    "email": "juan@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```
- Crear un autor
```http
POST /api/v1/authors
Authorization: Bearer [tu_token]
Content-Type: application/json

{
    "name": "Gabriel García Márquez",
    "birthdate": "1927-03-06",
    "nationality": "Colombiano"
}
```
- Crear un libro
```http
POST /api/v1/books
Authorization: Bearer [tu_token]
Content-Type: application/json

{
    "title": "Cien años de soledad",
    "isbn": "9780307474728",
    "published_date": "1967-05-30",
    "author_id": 1
}
```
## 📌 Nota importante

- Si estas utilizando Postman para probar los endpoints tendras que copiar el token que te genera JWT al hacer el login, y pegar manualmente en Authorization/Auth Type/Api key/value/Bearer {tu token}, esta version aun no cuenta con scripts para realizar eso de manera automatica.
