<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Support\TicketLabels;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    private const STATUS_COLORS = [
        'pending' => '#d97706',
        'in_progress' => '#2563eb',
        'resolved' => '#16a34a',
        'closed' => '#64748b',
    ];

    public function __invoke(): View
    {
        $user = Auth::user();
        $query = Ticket::query();

        if (! $user->isStaff()) {
            $query->where('requester_id', $user->id);
        }

        $stats = $this->summaryStats($query);
        $statusChart = $this->statusChart($query);

        return view('home', [
            'isStaff' => $user->isStaff(),
            'stats' => $stats,
            'statusChart' => $statusChart,
            'areaStats' => $user->isStaff() ? $this->topTicketsByRelation($query, 'area_id', 'area') : collect(),
            'categoryStats' => $user->isStaff() ? $this->topTicketsByRelation($query, 'ticket_category_id', 'category') : collect(),
            'requesterStats' => $user->isStaff() ? $this->topTicketsByRelation($query, 'requester_id', 'requester') : collect(),
            'assignedStats' => $user->isStaff() ? $this->topTicketsByRelation($query, 'assigned_user_id', 'assignedUser', false) : collect(),
            'solutionStats' => $user->isStaff() ? [
                'documented' => (clone $query)->whereHas('solution')->count(),
                'pending' => (clone $query)->whereIn('status', ['resolved', 'closed'])->whereDoesntHave('solution')->count(),
                'unassigned' => (clone $query)->whereNull('assigned_user_id')->count(),
            ] : [],
        ]);
    }

    private function summaryStats($query): array
    {
        return [
            'total' => (clone $query)->count(),
            'pending' => (clone $query)->where('status', 'pending')->count(),
            'in_progress' => (clone $query)->where('status', 'in_progress')->count(),
            'resolved' => (clone $query)->where('status', 'resolved')->count(),
            'closed' => (clone $query)->where('status', 'closed')->count(),
        ];
    }

    private function statusChart($query): array
    {
        $items = collect(array_keys(self::STATUS_COLORS))
            ->map(fn (string $status): array => [
                'key' => $status,
                'label' => TicketLabels::status($status),
                'value' => (clone $query)->where('status', $status)->count(),
                'color' => self::STATUS_COLORS[$status],
            ]);

        $total = $items->sum('value');
        $cursor = 0;
        $segments = [];

        foreach ($items as $item) {
            if ($total === 0 || $item['value'] === 0) {
                continue;
            }

            $end = $cursor + ($item['value'] / $total * 100);
            $segments[] = "{$item['color']} {$cursor}% {$end}%";
            $cursor = $end;
        }

        return [
            'items' => $items,
            'total' => $total,
            'gradient' => $segments === [] ? '#eef2f8 0% 100%' : implode(', ', $segments),
        ];
    }

    private function topTicketsByRelation($query, string $column, string $relation, bool $includeEmpty = true)
    {
        $items = (clone $query)
            ->select($column, DB::raw('COUNT(*) as total'))
            ->when(! $includeEmpty, fn ($query) => $query->whereNotNull($column))
            ->with($relation)
            ->groupBy($column)
            ->orderByDesc('total')
            ->limit(5)
            ->get()
            ->map(fn (Ticket $ticket): array => [
                'label' => $ticket->{$relation}?->name ?? 'Sin asignar',
                'value' => (int) $ticket->total,
            ]);

        $max = max($items->max('value') ?? 0, 1);

        return $items->map(fn (array $item): array => $item + [
            'percent' => round($item['value'] / $max * 100),
        ]);
    }
}
