<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Solution;
use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\TicketComment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $technician = User::create([
            'name' => 'Tecnico de Soporte',
            'email' => 'tecnico@example.com',
            'password' => Hash::make('password'),
            'role' => 'technician',
        ]);

        $user = User::create([
            'name' => 'Usuario Demo',
            'email' => 'usuario@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        $systems = Area::create([
            'name' => 'Sistemas',
            'description' => 'Problemas vinculados a acceso, software, equipos y conectividad.',
        ]);

        $academic = Area::create([
            'name' => 'Academica',
            'description' => 'Consultas o incidentes vinculados a cursado, aulas y materias.',
        ]);

        Area::create([
            'name' => 'Administracion',
            'description' => 'Tramites, pagos, legajos y documentacion.',
        ]);

        $access = TicketCategory::create([
            'name' => 'Accesos',
            'description' => 'Problemas de usuario, clave o permisos.',
        ]);

        $infrastructure = TicketCategory::create([
            'name' => 'Infraestructura',
            'description' => 'Problemas de aulas, equipamiento o conectividad.',
        ]);

        TicketCategory::create([
            'name' => 'Consulta general',
            'description' => 'Solicitudes que requieren clasificacion posterior.',
        ]);

        $ticket = Ticket::create([
            'title' => 'No puedo ingresar al campus virtual',
            'description' => 'El sistema indica credenciales invalidas aunque la clave fue actualizada.',
            'status' => 'in_progress',
            'priority' => 'high',
            'area_id' => $systems->id,
            'ticket_category_id' => $access->id,
            'requester_id' => $user->id,
            'assigned_user_id' => $technician->id,
        ]);

        TicketComment::create([
            'ticket_id' => $ticket->id,
            'user_id' => $technician->id,
            'body' => 'Se valida el usuario y se solicita captura del error para comparar con tickets previos.',
            'is_internal' => true,
        ]);

        $resolvedTicket = Ticket::create([
            'title' => 'Proyector del aula 3 sin imagen',
            'description' => 'El equipo enciende pero no muestra senal desde la notebook.',
            'status' => 'resolved',
            'priority' => 'medium',
            'area_id' => $academic->id,
            'ticket_category_id' => $infrastructure->id,
            'requester_id' => $user->id,
            'assigned_user_id' => $technician->id,
        ]);

        Solution::create([
            'ticket_id' => $resolvedTicket->id,
            'user_id' => $technician->id,
            'summary' => 'Se cambio la entrada HDMI seleccionada.',
            'details' => 'El proyector habia quedado configurado en VGA. Se selecciono HDMI 1 y se verifico imagen correctamente.',
        ]);
    }
}
