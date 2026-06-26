$ErrorActionPreference = "Stop"

function Write-Step {
    param([string]$Message)
    Write-Host ""
    Write-Host "== $Message ==" -ForegroundColor Cyan
}

function Require-Command {
    param(
        [string]$Name,
        [string]$InstallMessage
    )

    if (-not (Get-Command $Name -ErrorAction SilentlyContinue)) {
        Write-Host ""
        Write-Host "No se encontro $Name." -ForegroundColor Red
        Write-Host $InstallMessage
        exit 1
    }
}

Write-Host "Sistema Tickets - instalacion automatica para Windows" -ForegroundColor Green

Write-Step "Verificando requisitos"
Require-Command "git" "Instala Git desde https://git-scm.com/downloads y volve a ejecutar este script."
Require-Command "php" "Instala PHP 8.2 o superior y agregalo al PATH antes de continuar."
Require-Command "composer" "Instala Composer desde https://getcomposer.org/download/ y volve a ejecutar este script."

$phpVersion = & php -r "echo PHP_VERSION;"
if ([version]$phpVersion -lt [version]"8.2.0") {
    Write-Host "PHP $phpVersion detectado. Se requiere PHP 8.2 o superior." -ForegroundColor Red
    exit 1
}

Write-Host "Git, PHP $phpVersion y Composer detectados correctamente."

Write-Step "Instalando dependencias"
composer install

Write-Step "Preparando archivo .env"
if (-not (Test-Path ".env")) {
    Copy-Item ".env.example" ".env"
    Write-Host "Archivo .env creado desde .env.example."
} else {
    Write-Host "El archivo .env ya existe. No se modifico."
}

Write-Step "Preparando base de datos SQLite"
if (-not (Test-Path "database")) {
    New-Item -ItemType Directory -Path "database" | Out-Null
}

if (-not (Test-Path "database/database.sqlite")) {
    New-Item -ItemType File -Path "database/database.sqlite" -Force | Out-Null
    Write-Host "Base de datos creada en database/database.sqlite."
} else {
    Write-Host "La base de datos SQLite ya existe. No se borro ni se reemplazo."
}

Write-Step "Verificando APP_KEY"
$envContent = Get-Content ".env" -Raw
if ($envContent -match "APP_KEY=\s*(\r?\n|$)") {
    php artisan key:generate
} else {
    Write-Host "APP_KEY ya configurada. No se regenero."
}

Write-Step "Ejecutando migraciones y datos iniciales"
php artisan migrate --seed

Write-Host ""
Write-Host "Instalacion terminada correctamente." -ForegroundColor Green
Write-Host "Para iniciar el servidor ejecuta:"
Write-Host "php artisan serve" -ForegroundColor Yellow
Write-Host "Luego abri http://localhost:8000"
