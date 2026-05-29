<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('about:tickets', function (): void {
    $this->info('Sistema academico de tickets con Laravel 11, Blade y SQLite.');
})->purpose('Muestra informacion breve del proyecto');
