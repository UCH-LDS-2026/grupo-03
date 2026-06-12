# Instalar Xdebug para cobertura en Windows

Esta guia explica como habilitar cobertura para correr:

```bash
php artisan test --coverage
```

## 1. Verificar PHP

En PowerShell:

```powershell
php -v
php --ini
php -i
```

En esta maquina se detecto:

```text
PHP 8.2.31
Thread Safety: enabled
Compiler: Visual C++ 2019
Architecture: x64
Loaded php.ini: C:\Users\janla\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.2_Microsoft.Winget.Source_8wekyb3d8bbwe\php.ini
```

## 2. Descargar el DLL correcto

Ir a:

```text
https://xdebug.org/download
```

Elegir el binario que coincida con la version de PHP.

Para esta instalacion corresponde:

```text
PHP 8.2 TS VS16 (64 bit)
```

Archivo descargado:

```text
php_xdebug-3.5.3-8.2-ts-vs16-x86_64.dll
```

## 3. Copiar el DLL

Copiar el archivo descargado a la carpeta `ext` de PHP y renombrarlo como:

```text
php_xdebug.dll
```

En esta maquina quedo en:

```text
C:\Users\janla\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.2_Microsoft.Winget.Source_8wekyb3d8bbwe\ext\php_xdebug.dll
```

## 4. Editar php.ini

Abrir el archivo `php.ini` que muestra `php --ini` y agregar al final:

```ini
[Xdebug]
zend_extension=php_xdebug.dll
xdebug.mode=coverage
```

## 5. Verificar instalacion

Cerrar y abrir la terminal. Luego ejecutar:

```powershell
php -v
php -m
```

Debe aparecer:

```text
with Xdebug v3.5.3
```

y en la lista de modulos:

```text
xdebug
```

## 6. Ejecutar cobertura

Desde la raiz del proyecto:

```powershell
php artisan test --coverage
```

Para generar reporte HTML:

```powershell
php artisan test --coverage-html docs/coverage
```

Luego abrir:

```text
docs/coverage/index.html
```

## Resultado en este proyecto

La cobertura ya funciona. Resultado obtenido:

```text
Tests: 6 passed (18 assertions)
Total: 5.5 %
Services\TicketRules: 100.0 %
```
