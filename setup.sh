#!/usr/bin/env bash
set -e

print_step() {
    printf "\n== %s ==\n" "$1"
}

require_command() {
    local name="$1"
    local install_message="$2"

    if ! command -v "$name" >/dev/null 2>&1; then
        printf "\nNo se encontro %s.\n" "$name"
        printf "%s\n" "$install_message"
        exit 1
    fi
}

echo "Sistema Tickets - instalacion automatica para Linux/macOS"

print_step "Verificando requisitos"
require_command "git" "Instala Git con el gestor de paquetes de tu sistema y volve a ejecutar este script."
require_command "php" "Instala PHP 8.2 o superior y volve a ejecutar este script."
require_command "composer" "Instala Composer desde https://getcomposer.org/download/ y volve a ejecutar este script."

php_version="$(php -r 'echo PHP_VERSION;')"
php_version_ok="$(php -r 'echo version_compare(PHP_VERSION, "8.2.0", ">=") ? "yes" : "no";')"

if [ "$php_version_ok" != "yes" ]; then
    printf "PHP %s detectado. Se requiere PHP 8.2 o superior.\n" "$php_version"
    exit 1
fi

printf "Git, PHP %s y Composer detectados correctamente.\n" "$php_version"

print_step "Instalando dependencias"
composer install

print_step "Preparando archivo .env"
if [ ! -f ".env" ]; then
    cp ".env.example" ".env"
    echo "Archivo .env creado desde .env.example."
else
    echo "El archivo .env ya existe. No se modifico."
fi

print_step "Preparando base de datos SQLite"
mkdir -p database

if [ ! -f "database/database.sqlite" ]; then
    touch "database/database.sqlite"
    echo "Base de datos creada en database/database.sqlite."
else
    echo "La base de datos SQLite ya existe. No se borro ni se reemplazo."
fi

print_step "Verificando APP_KEY"
if grep -Eq '^APP_KEY=[[:space:]]*$' ".env"; then
    php artisan key:generate
else
    echo "APP_KEY ya configurada. No se regenero."
fi

print_step "Ejecutando migraciones y datos iniciales"
php artisan migrate --seed

printf "\nInstalacion terminada correctamente.\n"
printf "Para iniciar el servidor ejecuta:\n"
printf "php artisan serve\n"
printf "Luego abri http://localhost:8000\n"
