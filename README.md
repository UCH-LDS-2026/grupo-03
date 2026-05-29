#### Universidad Champagnat - Laboratorio de Desarrollo de Software - 2026

# Proyecto Final - Sistema de Tickets

## Grupo Nro. 3

## Integrantes

- Jan Eneas Lahorca
- Agustin Martinez
- Jose Manuel Moya

## Problema que resuelve

El sistema permite registrar, cuantificar y gestionar problemas reportados por usuarios de una organizacion o facultad. Busca evitar que las incidencias se pierdan, que los equipos repitan diagnosticos ya realizados y que las soluciones queden sin documentar.

La aplicacion centraliza los tickets, sus estados, prioridades, areas afectadas, categorias y soluciones aplicadas. De esta forma facilita el seguimiento operativo y permite construir una base de conocimiento reutilizable.

## Usuarios del sistema

1. Usuario
   - Crea tickets indicando descripcion, area y tipo de problema.
   - Consulta el estado de sus tickets.

2. Tecnico o responsable de soporte
   - Visualiza y gestiona tickets.
   - Cambia estado, prioridad y asignacion.
   - Busca problemas similares ya resueltos.
   - Documenta las soluciones aplicadas.

3. Administrador
   - Gestiona usuarios.
   - Define areas y categorias.
   - Revisa metricas generales del sistema.

## Funcionalidades principales del MVP

- Creacion de tickets.
- Listado y detalle de tickets.
- Gestion de estados: pendiente, en proceso, resuelto y cerrado.
- Asignacion de prioridad: baja, media, alta y urgente.
- Clasificacion por area y categoria.
- Comentarios internos o de seguimiento.
- Registro de solucion aplicada.
- Datos iniciales mediante seeders.

## Stack tecnologico principal

Esta version usa Laravel 11 + Blade + SQLite para simplificar la instalacion del proyecto y mantener una estructura clara de tipo MVC.

**Backend:** PHP >= 8.2 + Laravel 11  
**Frontend:** Blade + HTML + CSS  
**Base de datos:** SQLite  
**Manejador de paquetes:** Composer >= 2.7  
**Servidor local:** `php artisan serve`

## Por que Laravel 11 + Blade + SQLite

Laravel permite organizar el sistema con rutas, controladores, modelos Eloquent, migraciones, seeders y vistas Blade. Esto reduce codigo repetitivo y deja una estructura facil de explicar en un proyecto academico.

SQLite evita depender de MySQL, XAMPP o phpMyAdmin para levantar el proyecto. La base de datos se guarda en un archivo local (`database/database.sqlite`), suficiente para un MVP universitario y para ejecutar migraciones y seeders de forma simple.

## Requisitos previos

- PHP >= 8.2
- Composer >= 2.7
- Git

No es obligatorio instalar MySQL, XAMPP ni phpMyAdmin para esta version.

## Instalacion y ejecucion local

Pasos:

```bash
git clone https://github.com/UCH-LDS-2026/grupo-03.git
cd grupo-03
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

En Windows PowerShell, si no existe el archivo SQLite:

```powershell
New-Item -ItemType File -Path database/database.sqlite -Force
```

Luego ingresar a:

```text
http://localhost:8000
```

La configuracion por defecto usa SQLite, por lo que no hace falta instalar MySQL, XAMPP ni phpMyAdmin.

## Estructura general

```text
app/
  Http/Controllers/   Controladores MVC
  Models/             Modelos Eloquent
database/
  migrations/         Estructura de tablas
  seeders/            Datos iniciales
resources/
  views/              Vistas Blade
routes/
  web.php             Rutas web
docs/                 Documentacion del proyecto
trabajos-practicos/   Entregas y material de la cursada
```

## Estrategia de ramas

```text
main        -> codigo estable / produccion
develop     -> integracion de features
feature/*   -> nuevas funcionalidades
fix/*       -> correccion de bugs
```

## Reglas de la rama main

- Nadie hace push directo a `main`.
- Los cambios entran por Pull Request desde `develop`.
- Todo Pull Request requiere revision de al menos un integrante antes del merge.

## Convencion de commits

```text
feat:     nueva funcionalidad
fix:      correccion de bug
docs:     cambios en documentacion
style:    formato sin cambio de logica
refactor: refactorizacion
test:     pruebas automatizadas
```
