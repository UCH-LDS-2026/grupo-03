# Arquitectura del sistema

## Stack tecnologico

- Frontend: Blade + HTML + CSS.
- Backend: PHP >= 8.2 + Laravel 11.
- Base de datos: SQLite.
- Persistencia: migraciones y modelos Eloquent.
- Datos iniciales: seeders.
- Servidor local: `php artisan serve`.

## Arquitectura general

El sistema sigue una arquitectura MVC usando las convenciones de Laravel:

- Modelos: representan las entidades principales y sus relaciones.
- Vistas Blade: renderizan las pantallas HTML del sistema.
- Controladores: reciben las solicitudes, validan datos y coordinan la respuesta.
- Rutas: definen las URL disponibles para la aplicacion.
- Migraciones: versionan la estructura de la base de datos.
- Seeders: cargan datos iniciales para desarrollo y demostracion.

## SQLite

La aplicacion usa SQLite para simplificar la instalacion. La base de datos se guarda en `database/database.sqlite`, por lo que no hace falta instalar MySQL, XAMPP ni phpMyAdmin.

Esta decision es adecuada para el MVP academico porque permite levantar el proyecto con pocos pasos y mantiene compatibilidad con migraciones, seeders y Eloquent.

## Estructura de carpetas

```text
app/
  Http/Controllers/
    HomeController.php
    TicketController.php
  Models/
    Area.php
    Solution.php
    Ticket.php
    TicketCategory.php
    TicketComment.php
    User.php
bootstrap/
config/
database/
  migrations/
  seeders/
public/
  css/app.css
resources/
  views/
routes/
  web.php
docs/
trabajos-practicos/
```

## Flujo basico

1. El usuario accede a una ruta definida en `routes/web.php`.
2. Laravel ejecuta el controlador correspondiente.
3. El controlador consulta o modifica datos mediante modelos Eloquent.
4. Eloquent persiste los datos en SQLite.
5. El controlador devuelve una vista Blade.
6. Blade genera el HTML mostrado en el navegador.

## Diagrama textual

```text
Navegador
   |
   v
routes/web.php
   |
   v
Controladores Laravel
   |
   v
Modelos Eloquent
   |
   v
SQLite database/database.sqlite
   |
   v
Vistas Blade
```
