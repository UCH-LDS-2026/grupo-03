<?php

namespace Tests\Unit;

use App\Models\Ticket;
use App\Models\User;
use App\Services\TicketRules;
use PHPUnit\Framework\TestCase;

class TicketRulesTest extends TestCase
{
    private TicketRules $rules;

    protected function setUp(): void
    {
        parent::setUp();

        $this->rules = new TicketRules();
    }

    public function test_ticket_initial_status_is_pending(): void
    {
        $this->assertSame('pending', $this->rules->initialStatus());
    }

    public function test_recognizes_valid_statuses_and_rejects_unknown_status(): void
    {
        $this->assertTrue($this->rules->isValidStatus('pending'));
        $this->assertTrue($this->rules->isValidStatus('in_progress'));
        $this->assertTrue($this->rules->isValidStatus('resolved'));
        $this->assertTrue($this->rules->isValidStatus('closed'));
        $this->assertFalse($this->rules->isValidStatus('cancelled'));
    }

    public function test_recognizes_valid_priorities_and_rejects_unknown_priority(): void
    {
        $this->assertTrue($this->rules->isValidPriority('low'));
        $this->assertTrue($this->rules->isValidPriority('medium'));
        $this->assertTrue($this->rules->isValidPriority('high'));
        $this->assertTrue($this->rules->isValidPriority('urgent'));
        $this->assertFalse($this->rules->isValidPriority('critical'));
    }

    public function test_staff_can_view_any_ticket(): void
    {
        $admin = $this->user(1, 'admin');
        $technician = $this->user(2, 'technician');
        $ticket = $this->ticket(requesterId: 99);

        $this->assertTrue($this->rules->canView($admin, $ticket));
        $this->assertTrue($this->rules->canView($technician, $ticket));
    }

    public function test_regular_user_can_only_view_own_ticket(): void
    {
        $user = $this->user(10, 'user');
        $ownTicket = $this->ticket(requesterId: 10);
        $otherTicket = $this->ticket(requesterId: 99);

        $this->assertTrue($this->rules->canView($user, $ownTicket));
        $this->assertFalse($this->rules->canView($user, $otherTicket));
    }

    public function test_regular_user_can_edit_only_own_pending_ticket(): void
    {
        $user = $this->user(10, 'user');
        $ownPendingTicket = $this->ticket(requesterId: 10, status: 'pending');
        $ownResolvedTicket = $this->ticket(requesterId: 10, status: 'resolved');
        $otherPendingTicket = $this->ticket(requesterId: 99, status: 'pending');

        $this->assertTrue($this->rules->canEdit($user, $ownPendingTicket));
        $this->assertFalse($this->rules->canEdit($user, $ownResolvedTicket));
        $this->assertFalse($this->rules->canEdit($user, $otherPendingTicket));
    }

    private function user(int $id, string $role): User
    {
        $user = new User([
            'name' => "User {$id}",
            'email' => "user{$id}@example.com",
            'role' => $role,
        ]);

        $user->id = $id;

        return $user;
    }

    private function ticket(int $requesterId, string $status = 'pending'): Ticket
    {
        return new Ticket([
            'requester_id' => $requesterId,
            'status' => $status,
        ]);
    }
}
