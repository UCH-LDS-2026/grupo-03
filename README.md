#### Universidad Champagnat - Laboratorio de Desarrollo de Software - 2026

# Proyecto Final
## Grupo N° 3

## Integrantes:
- Jan Eneas Lahorca
- Agustin Martinez
- Jose Manuel Moya

## Problema que resuelve

Las empresas no solo presentan dificultades en la gestión y seguimiento de incidencias, sino también en el aprovechamiento del conocimiento generado a lo largo del tiempo, ya que los problemas resueltos no quedan sistematizados ni reutilizables. Esto provoca que el equipo de mantenimiento repita diagnósticos y soluciones ya aplicadas, sin poder identificar fácilmente si un problema es nuevo o recurrente, afectando la eficiencia y los tiempos de respuesta.

## Usuarios

Usuarios del sistema
1. Usuario (Empleado)

-Crea tickets indicando descripción, área y tipo de problema

2. Técnico (Mantenimiento)

-Ve y gestiona todos los tickets (estado, prioridad, asignación)
-Busca soluciones documentadas de problemas similares
-Documenta las soluciones aplicadas

3. Administrador

-Gestiona usuarios del sistema
-Define áreas de la empresa
-Configura parámetros del sistema

## Funcionalidades principales
-Creación de tickets: Los usuarios registran incidencias con descripción, área y tipo de problema.

-Gestión de estados: Los tickets pasan por los estados pendiente → en proceso → resuelto.

-Asignación y prioridad: Los técnicos se asignan tickets y definen su nivel de prioridad.

-Búsqueda de soluciones: El técnico puede buscar tickets similares ya resueltos por área, tipo de problema o palabras clave.

-Registro de soluciones: El técnico documenta cómo resolvió el problema, alimentando la base de conocimiento.



# VERSIÓN A — PHP puro + HTML/CSS + MySQL

Esta es la versión con el stack que el grupo ya conoce.
Es la opción más directa para el proyecto de cursada.


## ¿Por qué este stack?
Se eligió PHP puro como lenguaje de backend porque permite manejar la lógica del servidor y generar las vistas HTML sin capas adicionales, lo que facilita la comprensión del flujo completo por parte de todos los integrantes. El frontend se construye con HTML y CSS estándar, tecnologías que el equipo domina y que son suficientes para una interfaz funcional y clara. MySQL fue seleccionado por su compatibilidad nativa con PHP mediante PDO y su soporte de integridad referencial, fundamental para mantener la consistencia entre tickets, usuarios, áreas y soluciones. La búsqueda de tickets similares se resuelve con consultas SQL usando WHERE, LIKE y ORDER BY, sin necesidad de herramientas externas. En conjunto, este stack permite enfocarse en la lógica del negocio sin curva de aprendizaje adicional.

## Stack
**Backend:** PHP >= 8.2

**Frontend:** HTML + CSS

**Base de datos:** MySQL >= 8.0

**Servidor local:** XAMPP>= 8.2

## Requisitos previos

XAMPP >= 8.2 (incluye PHP y MySQL)
Git
Instalación y setup
1. Clonar el repositorio
bashgit clone https://github.com/<usuario>/sistema-tickets.git
2. Mover la carpeta a htdocs
Copiar la carpeta del proyecto dentro de:
C:\xampp\htdocs\sistema-tickets       (Windows)
/Applications/XAMPP/htdocs/sistema-tickets  (Mac)
3. Crear la base de datos
Abrir phpMyAdmin desde el panel de XAMPP e importar el archivo:
database/schema.sql
4. Configurar la conexión
Copiar el archivo de ejemplo y editarlo:
bashcp config/db.example.php config/db.php
php<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'sistema_tickets');
define('DB_USER', 'root');
define('DB_PASS', '');
5. Iniciar el sistema
Iniciar Apache y MySQL desde el panel de XAMPP y acceder a:
http://localhost/sistema-tickets

# VERSIÓN B — Laravel + MySQL

Esta es la versión con el stack recomendado técnicamente.
Requiere aprender algunas herramientas nuevas, pero el resultado
es un código más ordenado, seguro y fácil de mantener en equipo.


## ¿Por qué este stack?
Se eligió Laravel porque el sistema requiere funcionalidades que en PHP puro hay que construir desde cero: autenticación con roles diferenciados (empleado, técnico, administrador), validaciones de formularios, control de acceso por rol y relaciones entre entidades. Laravel provee todo esto de forma integrada y probada, reduciendo el código repetitivo y los errores de seguridad comunes. El motor de templates Blade es esencialmente PHP mezclado con HTML con una sintaxis más limpia, por lo que la curva de aprendizaje es mínima para quienes ya conocen PHP. MySQL se mantiene como base de datos por las mismas razones que en la versión A: compatibilidad nativa, integridad referencial y capacidad de búsqueda relacional suficiente para el sistema. El servidor de desarrollo integrado (php artisan serve) garantiza que el entorno funcione igual en todas las máquinas del grupo sin configuración adicional.

## Stack

**Backend:** PHP + LaravelPHP >= 8.2, Laravel 11

**Frontend:** Blade + HTML/CSS

**Base de datos:** MySQL >= 8.0

**Manejador de paquetes:** Composer >= 2.7

**Servidor local:** php artisan serve

Blade es el sistema de templates de Laravel. Es PHP + HTML con sintaxis simplificada. 


## Requisitos previos
-PHP >= 8.2

-Composer >= 2.7

-MySQL >= 8.0

-Git


## Instalación y setup
1. Clonar el repositorio
bashgit clone https://github.com/<usuario>/sistema-tickets.git
cd sistema-tickets
2. Instalar dependencias
bashcomposer install
3. Configurar el entorno
bashcp .env.example .env
php artisan key:generate
Editar .env:
envDB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistema_tickets
DB_USERNAME=root
DB_PASSWORD=
4. Crear la base de datos y ejecutar migraciones
sqlCREATE DATABASE sistema_tickets CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
bashphp artisan migrate --seed
5. Iniciar el servidor
bashphp artisan serve
Acceder a: http://localhost:8000


## Estrategia de ramas (ambas versiones)
main        → código estable / producción  (PROTEGIDA)

develop     → integración de features

feature/*   → nuevas funcionalidades

fix/*       → corrección de bugs


## Reglas de la rama main:

-Nadie hace push directo a main

-Los cambios entran únicamente por Pull Request desde develop

-Todo PR requiere revisión de al menos un integrante antes del merge

## Convención de commits:
feat:     nueva funcionalidad

fix:      corrección de bug

docs:     cambios en documentación

style:    formato sin cambio de lógica

refactor: refactorización

