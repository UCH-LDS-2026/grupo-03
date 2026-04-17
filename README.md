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

1. Usuario (Empleado)
  -Crea tickets
2. Técnico (Mantenimiento)
  -Ve todos los tickets
  -Los gestiona (estado, prioridad, asignación)
  -Usa las sugerencias de la “IA”
  -Documenta soluciones
3. Administrador
  -Gestiona usuarios
  -Define áreas
  -Configura el sistema

## Funcionalidades principales

  ● Creación de tickets: Los usuarios pueden registrar incidencias indicando descripción, área y tipo de problema.
  ● Gestión de estados: Los tickets pueden cambiar de estado (pendiente, en proceso, resuelto), permitiendo hacer seguimiento claro.
  ● Asignación y prioridad: Los técnicos pueden asignarse tickets y definir su nivel de prioridad para organizar el trabajo.
  ● Sugerencias inteligentes (soporte al técnico): El sistema sugiere posibles soluciones basadas en problemas similares previamente resueltos e IA.
  ● Registro de soluciones: El técnico documenta cómo resolvió el problema y si la sugerencia fue útil, alimenta la base de conocimiento.

## Stack tecnológico

Frontend:PHP, HTML, CSS
Backend:PHP
Base de datos:MySQL

## Cómo ejecutar el proyecto

Requisitos previos
- Tener instalado:
  - PHP 
  - MySQL
  - Servidor local (XAMPP, WAMP o similar)
    
1- Clonar el repositorio (git clone).
2- Importar la base de datos en MySQL.
3- Configurar la conexión a la base de datos.
4- Ejecutar el proyecto en un servidor local: XAMPP/WAMP.
5- Acceder desde el navegador: http://localhost/nombre-del-proyecto

