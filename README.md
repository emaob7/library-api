# 📚 Biblioteca API - Documentación Técnica

## 🔍 Información General
**Versión:** 1.0.0  
**Tecnologías:**  
- Laravel 12
- PHP 8.4
- MySQL 8.0
- Sanctum (Autenticación JWT)

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
