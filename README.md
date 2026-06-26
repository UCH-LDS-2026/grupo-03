#### Universidad Champagnat - Laboratorio de Desarrollo de Software - 2026

# Proyecto Final - Sistema de Tickets

## Grupo Nro. 3

## Integrantes

- Jan Eneas Lahorca
- Agustín Martinez
- Jose Manuel Moya

## Problema que resuelve

El sistema permite registrar, cuantificar y gestionar problemas reportados por usuarios de una organización o facultad. Busca evitar que las incidencias se pierdan, que los equipos repitan diagnósticos ya realizados y que las soluciones queden sin documentar.

La aplicación centraliza los tickets, sus estados, prioridades, áreas afectadas, categorías, comentarios y soluciones aplicadas. De esta forma facilita el seguimiento operativo y permite construir una base de conocimiento reutilizable.

## Propuesta de valor

El proyecto resuelve un problema concreto de organización interna: cuando los reclamos o incidentes se gestionan por mensajes sueltos, correos o conversaciones informales, es difícil saber qué está pendiente, quién lo está atendiendo y qué solución se aplicó.

El sistema aporta valor porque ordena ese flujo en una herramienta única. Cada ticket queda registrado con solicitante, área, categoría, prioridad, estado, responsable asignado, comentarios y solución documentada. Esto permite dar seguimiento, priorizar mejor el trabajo y reutilizar soluciones ante problemas similares.

## Usuarios del sistema

1. Usuario
   - Crea tickets indicando descripción, área y tipo de problema.
   - Consulta el estado de sus tickets.

2. Técnico o responsable de soporte
   - Visualiza y gestiona tickets.
   - Cambia estado, prioridad y asignación.
   - Busca problemas similares ya resueltos.
   - Documenta las soluciones aplicadas.

3. Administrador
   - Gestiona usuarios.
   - Define áreas y categorías.
   - Revisa métricas generales del sistema.

## Funcionalidades principales del MVP

- Creación de tickets.
- Listado y detalle de tickets.
- Gestión de estados: pendiente, en proceso, resuelto y cerrado.
- Asignación de prioridad: baja, media, alta y urgente.
- Clasificación por área y categoría.
- Comentarios internos o de seguimiento.
- Registro de solución aplicada.
- Datos iniciales mediante seeders.

## Alcance del MVP

El MVP se enfoca en el flujo principal de gestión de tickets:

1. Un usuario ingresa al sistema.
2. Crea un ticket indicando el problema, el área, la categoría y la prioridad.
3. Un técnico o administrador visualiza el ticket.
4. El equipo de soporte asigna responsable, cambia estado, agrega comentarios y documenta la solución.
5. El usuario puede consultar el estado de sus tickets.

Quedan fuera del MVP funcionalidades más avanzadas como notificaciones por correo, adjuntos, historial completo de cambios de estado, reportes gráficos o base de conocimiento pública.

## Stack tecnológico principal

Esta versión usa Laravel 11 + Blade + SQLite para simplificar la instalación del proyecto y mantener una estructura clara de tipo MVC.

**Backend:** PHP >= 8.2 + Laravel 11  
**Frontend:** Blade + HTML + CSS  
**Base de datos:** SQLite  
**Manejador de paquetes:** Composer >= 2.7  
**Servidor local:** `php artisan serve`

## Por qué Laravel 11 + Blade + SQLite

Laravel permite organizar el sistema con rutas, controladores, modelos Eloquent, migraciones, seeders y vistas Blade. Esto reduce código repetitivo y deja una estructura fácil de explicar en un proyecto académico.

SQLite evita depender de MySQL, XAMPP o phpMyAdmin para levantar el proyecto. La base de datos se guarda en `database/database.sqlite`, suficiente para un MVP universitario y para ejecutar migraciones y seeders de forma simple.

## Requisitos previos

- PHP >= 8.2
- Composer >= 2.7
- Git

No es obligatorio instalar MySQL, XAMPP ni phpMyAdmin para esta versión.

## Instalación automática

El proyecto incluye scripts de instalación para preparar el entorno de forma más simple. Los scripts no borran la base de datos existente ni ejecutan comandos destructivos: si `database/database.sqlite` ya existe, se conserva.

Antes de ejecutar el script, la computadora debe tener instalados:

- Git
- PHP 8.2 o superior
- Composer

Si falta alguno, el script muestra qué herramienta falta y se detiene.

### Windows PowerShell

Desde la carpeta del proyecto:

```powershell
.\setup.ps1
```

Si PowerShell bloquea la ejecución de scripts, ejecutar este comando una sola vez en esa terminal y volver a intentar:

```powershell
Set-ExecutionPolicy -Scope Process -ExecutionPolicy Bypass
```

### Linux/macOS

Desde la carpeta del proyecto:

```bash
chmod +x setup.sh
./setup.sh
```

Cuando el script termina, iniciar el servidor local con:

```bash
php artisan serve
```

Ingresar a:

```text
http://localhost:8000
```

## Instalación manual

Pasos:

```bash
git clone https://github.com/UCH-LDS-2026/grupo-03.git
cd grupo-03
composer install
cp .env.example .env
php artisan key:generate
```

En Windows PowerShell, si no existe el archivo SQLite, crearlo antes de ejecutar las migraciones:

```powershell
New-Item -ItemType File -Path database/database.sqlite -Force
```

Luego ejecutar:

```bash
php artisan migrate --seed
php artisan serve
```

Ingresar a:

```text
http://localhost:8000
```

La configuración por defecto usa SQLite, por lo que no hace falta instalar MySQL, XAMPP ni phpMyAdmin.

## Instalación de herramientas necesarias

Si la computadora no tiene las herramientas instaladas, se pueden instalar de esta forma:

### Git

Descargar e instalar desde:

```text
https://git-scm.com/downloads
```

Verificar la instalación:

```bash
git --version
```

### PHP

Se requiere PHP 8.2 o superior. Verificar si ya está instalado:

```bash
php -v
```

En Windows se puede instalar PHP desde:

```text
https://windows.php.net/download/
```

También se puede usar una instalación que ya venga incluida con herramientas como Laragon, siempre que `php` esté disponible desde la terminal.

En Linux, según la distribución:

```bash
sudo apt install php php-cli php-sqlite3 php-mbstring php-xml php-curl php-zip
```

### Composer

Descargar e instalar desde:

```text
https://getcomposer.org/download/
```

Verificar la instalación:

```bash
composer --version
```

## Problemas frecuentes

- Si aparece `php no se reconoce como comando`, PHP no está agregado al PATH.
- Si aparece `composer no se reconoce como comando`, Composer no está instalado o no está agregado al PATH.
- Si falla SQLite, revisar que exista el archivo `database/database.sqlite`.
- Si la página carga pero no deja iniciar sesión, ejecutar `php artisan migrate --seed`.
- Si el puerto 8000 está ocupado, iniciar el servidor con otro puerto:

```bash
php artisan serve --port=8080
```

## Usuarios de demostración

Los seeders crean usuarios iniciales para probar los roles del sistema:

| Rol | Correo electrónico | Contraseña |
| --- | --- | --- |
| Administrador | `admin@example.com` | `password` |
| Técnico | `tecnico@example.com` | `password` |
| Usuario | `usuario@example.com` | `password` |

## Pruebas

El proyecto incluye pruebas unitarias sobre reglas de negocio del sistema de tickets. Para ejecutarlas:

```bash
php artisan test
```

Las pruebas cubren la clase `App\Services\TicketRules`, donde se validan estados, prioridades y permisos de visualización/edición.

Para generar cobertura:

```bash
php artisan test --coverage
```

Este comando requiere tener Xdebug o PCOV habilitado. La documentación del TP4 y el reporte de cobertura se encuentran en `docs/`.

## Estructura general

```text
app/
  Http/Controllers/   Controladores MVC
  Models/             Modelos Eloquent
  Services/           Reglas de negocio
  Support/            Helpers de presentación
database/
  migrations/         Estructura de tablas
  seeders/            Datos iniciales
lang/
  es/                 Traducciones de validación
resources/
  views/              Vistas Blade
routes/
  web.php             Rutas web
docs/                 Documentación técnica del proyecto
trabajos-practicos/   Entregas y material de la cursada
```

## Documentación técnica

La carpeta `docs/` reúne la documentación técnica vigente:

- `arquitectura.md`: arquitectura MVC, stack y flujo general.
- `modelo-datos.md`: entidades, campos principales y relaciones.
- `diagrama-entidad-relacion.md`: DER actualizado en formato Mermaid.
- `tp4-testing.md`: estrategia de testing y cobertura.
- `tp4-test-report.md`: reporte de ejecución de pruebas.
- `coverage/`: reporte HTML de cobertura generado con PHPUnit.

## Estrategia de ramas

```text
main        -> código estable / producción
develop     -> integracion de features
feature/*   -> nuevas funcionalidades
fix/*       -> corrección de bugs
```

## Reglas de la rama main

- Nadie hace push directo a `main`.
- Los cambios entran por Pull Request desde `develop`.
- Todo Pull Request requiere revisión de al menos un integrante antes del merge.

## Convención de commits

```text
feat:     nueva funcionalidad
fix:      corrección de bug
docs:     cambios en documentación
style:    formato sin cambio de logica
refactor: refactorización
test:     pruebas automatizadas
```
