<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $user = Auth::user();
        $query = Ticket::query();

        if (! $user->isStaff()) {
            $query->where('requester_id', $user->id);
        }

        $stats = [
            'total' => (clone $query)->count(),
            'pending' => (clone $query)->where('status', 'pending')->count(),
            'in_progress' => (clone $query)->where('status', 'in_progress')->count(),
            'resolved' => (clone $query)->where('status', 'resolved')->count(),
        ];

        $latestTickets = (clone $query)
            ->with(['area', 'category', 'requester'])
            ->latest()
            ->limit(5)
            ->get();

        return view('home', compact('stats', 'latestTickets'));
    }
}
