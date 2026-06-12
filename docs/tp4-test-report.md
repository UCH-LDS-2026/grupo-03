# TP4 - Reporte de ejecucion de tests

Fecha de ejecucion: 2026-06-12

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
Duration: 1.01s
```

## Cobertura

Se genero cobertura con:

```bash
php artisan test --coverage
```

Resultado principal:

```text
Tests:    6 passed (18 assertions)
Total:    5.5 %
```

Detalle destacado:

```text
Services\TicketRules  100.0%
Models\User            77.8%
```

Tambien se genero un reporte HTML navegable con:

```bash
php artisan test --coverage-html docs/coverage
```

Archivo principal del reporte:

```text
docs/coverage/index.html
```

## Driver de cobertura

Para poder calcular cobertura se instalo y habilito Xdebug 3.5.3 en PHP 8.2.31 con:

```ini
zend_extension=php_xdebug.dll
xdebug.mode=coverage
```

PHP confirma que Xdebug esta activo con:

```bash
php -v
```

Salida esperada:

```text
with Xdebug v3.5.3
```
