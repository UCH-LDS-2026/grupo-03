# TP4 - Reporte de ejecucion de tests

Fecha de ejecucion: 2026-06-11

## Comando ejecutado

```bash
php artisan test
```

## Resultado

```text
PASS  Tests\Unit\TicketRulesTest
PASS ticket initial status is pending
PASS recognizes valid statuses and rejects unknown status
PASS recognizes valid priorities and rejects unknown priority
PASS staff can view any ticket
PASS regular user can only view own ticket
PASS regular user can edit only own pending ticket

Tests:    6 passed (18 assertions)
Duration: 0.36s
```

## Cobertura

Se intento generar cobertura con:

```bash
php artisan test --coverage
```

Resultado de la instalacion local:

```text
ERROR  Code coverage driver not available. Did you install Xdebug or PCOV?
```

Para generar el porcentaje de cobertura es necesario instalar y habilitar Xdebug o PCOV en PHP. La suite de tests queda ejecutable por CLI y lista para generar cobertura cuando el entorno tenga alguno de esos drivers habilitado.
