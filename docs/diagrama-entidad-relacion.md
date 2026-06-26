# Diagrama de entidad relacion

Este DER se basa en las migraciones y modelos actuales del proyecto.

```mermaid
erDiagram
    USERS {
        bigint id PK
        string name
        string email UK
        timestamp email_verified_at
        string password
        string role
        string remember_token
        timestamp created_at
        timestamp updated_at
    }

    AREAS {
        bigint id PK
        string name UK
        text description
        timestamp created_at
        timestamp updated_at
    }

    TICKET_CATEGORIES {
        bigint id PK
        string name UK
        text description
        timestamp created_at
        timestamp updated_at
    }

    TICKETS {
        bigint id PK
        string title
        text description
        string status
        string priority
        bigint area_id FK
        bigint ticket_category_id FK
        bigint requester_id FK
        bigint assigned_user_id FK
        timestamp created_at
        timestamp updated_at
    }

    TICKET_COMMENTS {
        bigint id PK
        bigint ticket_id FK
        bigint user_id FK
        text body
        boolean is_internal
        timestamp created_at
        timestamp updated_at
    }

    SOLUTIONS {
        bigint id PK
        bigint ticket_id FK,UK
        bigint user_id FK
        string summary
        text details
        timestamp created_at
        timestamp updated_at
    }

    PASSWORD_RESET_TOKENS {
        string email PK
        string token
        timestamp created_at
    }

    SESSIONS {
        string id PK
        bigint user_id FK
        string ip_address
        text user_agent
        longtext payload
        integer last_activity
    }

    USERS ||--o{ TICKETS : "crea como requester"
    USERS ||--o{ TICKETS : "tiene asignados"
    AREAS ||--o{ TICKETS : "clasifica"
    TICKET_CATEGORIES ||--o{ TICKETS : "categoriza"
    TICKETS ||--o{ TICKET_COMMENTS : "tiene"
    USERS ||--o{ TICKET_COMMENTS : "escribe"
    TICKETS ||--o| SOLUTIONS : "puede tener"
    USERS ||--o{ SOLUTIONS : "documenta"
    USERS ||--o{ SESSIONS : "inicia"
```

## Reglas principales

- Un usuario puede crear muchos tickets mediante `tickets.requester_id`.
- Un usuario tecnico o administrador puede tener muchos tickets asignados mediante `tickets.assigned_user_id`; este campo puede ser nulo.
- Un area puede estar asociada a muchos tickets.
- Una categoria puede estar asociada a muchos tickets.
- Un ticket puede tener muchos comentarios.
- Cada comentario pertenece a un ticket y a un usuario.
- Un ticket puede tener como maximo una solucion porque `solutions.ticket_id` es unico.
- Cada solucion pertenece a un ticket y al usuario que la documento.
- `password_reset_tokens` y `sessions` son tablas auxiliares de autenticacion/sesion de Laravel.

## Cardinalidades resumidas

| Relacion | Cardinalidad |
| --- | --- |
| `users` a `tickets` como solicitante | 1 a N |
| `users` a `tickets` como asignado | 1 a N opcional desde `tickets` |
| `areas` a `tickets` | 1 a N |
| `ticket_categories` a `tickets` | 1 a N |
| `tickets` a `ticket_comments` | 1 a N |
| `users` a `ticket_comments` | 1 a N |
| `tickets` a `solutions` | 1 a 0..1 |
| `users` a `solutions` | 1 a N |
| `users` a `sessions` | 1 a N opcional desde `sessions` |
