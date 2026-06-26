<?php

namespace App\Support;

class TicketLabels
{
    private const STATUSES = [
        'pending' => 'Pendiente',
        'in_progress' => 'En proceso',
        'resolved' => 'Resuelto',
        'closed' => 'Cerrado',
    ];

    private const PRIORITIES = [
        'low' => 'Baja',
        'medium' => 'Media',
        'high' => 'Alta',
        'urgent' => 'Urgente',
    ];

    private const ROLES = [
        'user' => 'Usuario común',
        'technician' => 'Técnico',
        'admin' => 'Administrador',
    ];

    public static function status(string $status): string
    {
        return self::STATUSES[$status] ?? $status;
    }

    public static function priority(string $priority): string
    {
        return self::PRIORITIES[$priority] ?? $priority;
    }

    public static function role(string $role): string
    {
        return self::ROLES[$role] ?? $role;
    }
}
