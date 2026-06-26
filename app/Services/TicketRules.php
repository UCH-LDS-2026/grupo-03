<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\User;

class TicketRules
{
    public const INITIAL_STATUS = 'pending';

    private const VALID_STATUSES = [
        'pending',
        'in_progress',
        'resolved',
        'closed',
    ];

    private const VALID_PRIORITIES = [
        'low',
        'medium',
        'high',
        'urgent',
    ];

    public function canView(User $user, Ticket $ticket): bool
    {
        return $user->isStaff() || $ticket->requester_id === $user->id;
    }

    public function canEdit(User $user, Ticket $ticket): bool
    {
        return $user->isStaff()
            || ($ticket->requester_id === $user->id && $ticket->status === self::INITIAL_STATUS);
    }

    public function initialStatus(): string
    {
        return self::INITIAL_STATUS;
    }

    public function validStatuses(): array
    {
        return self::VALID_STATUSES;
    }

    public function validPriorities(): array
    {
        return self::VALID_PRIORITIES;
    }

    public function isValidStatus(string $status): bool
    {
        return in_array($status, $this->validStatuses(), true);
    }

    public function isValidPriority(string $priority): bool
    {
        return in_array($priority, $this->validPriorities(), true);
    }
}
