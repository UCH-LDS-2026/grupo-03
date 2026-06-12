# TP4 - Testing y cobertura

## Objetivo

Se agregaron pruebas unitarias para validar reglas de negocio del sistema de tickets. El foco esta puesto en decisiones propias de la aplicacion, no en probar funcionalidades internas de Laravel.

## Logica testeada

Los tests cubren la clase `App\Services\TicketRules`, que centraliza reglas usadas por `TicketController`:

- Estado inicial de un ticket nuevo.
- Estados validos del flujo de tickets.
- Prioridades validas.
- Permisos de visualizacion para staff y usuarios comunes.
- Permisos de edicion para usuarios comunes segun propietario y estado del ticket.

## Tests unitarios

Archivo principal:

```text
tests/Unit/TicketRulesTest.php
```

Casos incluidos:

1. `test_ticket_initial_status_is_pending`
2. `test_recognizes_valid_statuses_and_rejects_unknown_status`
3. `test_recognizes_valid_priorities_and_rejects_unknown_priority`
4. `test_staff_can_view_any_ticket`
5. `test_regular_user_can_only_view_own_ticket`
6. `test_regular_user_can_edit_only_own_pending_ticket`

## Como ejecutar

Desde la raiz del proyecto:

```bash
php artisan test
```

## Cobertura

Laravel permite generar cobertura con:

```bash
php artisan test --coverage
```

Este comando requiere tener Xdebug o PCOV instalado y habilitado en PHP. Si la extension no esta disponible en la maquina local, los tests pueden ejecutarse igual con `php artisan test`, pero no se puede calcular el porcentaje de cobertura desde esa instalacion.
