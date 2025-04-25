# 📚 Biblioteca API - Documentación Técnica

## 🔍 Información General
**Versión:** 1.0.0  
**Tecnologías:**  
- Laravel 12
- PHP 8.4
- MySQL 8.0
- Sanctum (Autenticación JWT)

API RESTful para la gestión de una biblioteca en línea con autenticación JWT, desarrollada con Laravel 12 y PHP 8.4.

##📌 Características principales
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
nano .env

# Ejecutar migraciones
php artisan migrate --seed

# Iniciar servidor
php artisan serve

