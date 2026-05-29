# Modelo de datos

## Entidades principales

### users

Representa a las personas que usan el sistema.

Campos principales:

- id
- name
- email
- password
- role
- timestamps

Roles previstos:

- user: crea y consulta tickets.
- technician: gestiona tickets y documenta soluciones.
- admin: administra datos base y usuarios.

### areas

Representa el sector o area relacionada con el problema.

Campos principales:

- id
- name
- description
- timestamps

Ejemplos:

- Sistemas
- Academica
- Administracion

### ticket_categories

Representa el tipo de problema reportado.

Campos principales:

- id
- name
- description
- timestamps

Ejemplos:

- Accesos
- Infraestructura
- Consulta general

### tickets

Representa cada problema o solicitud registrada.

Campos principales:

- id
- title
- description
- status
- priority
- area_id
- ticket_category_id
- requester_id
- assigned_user_id
- timestamps

Estados iniciales:

- pending
- in_progress
- resolved
- closed

Prioridades iniciales:

- low
- medium
- high
- urgent

### ticket_comments

Representa comentarios o avances sobre un ticket.

Campos principales:

- id
- ticket_id
- user_id
- body
- is_internal
- timestamps

### solutions

Representa la solucion documentada para un ticket resuelto.

Campos principales:

- id
- ticket_id
- user_id
- summary
- details
- timestamps

Se modela en una tabla separada para facilitar la busqueda futura de soluciones reutilizables.

## Relaciones

- Un usuario puede crear muchos tickets.
- Un usuario tecnico puede tener muchos tickets asignados.
- Un area puede tener muchos tickets.
- Una categoria puede tener muchos tickets.
- Un ticket pertenece a un area.
- Un ticket pertenece a una categoria.
- Un ticket pertenece a un usuario solicitante.
- Un ticket puede pertenecer a un usuario asignado.
- Un ticket puede tener muchos comentarios.
- Un ticket puede tener una solucion.

## Decision sobre historial de estados

Para el MVP inicial no se crea `ticket_status_history`. El estado actual queda guardado en `tickets.status`.

La tabla `ticket_status_history` puede agregarse mas adelante si la catedra solicita auditoria de cambios o trazabilidad completa de estados.
