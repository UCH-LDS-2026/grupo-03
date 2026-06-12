<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Solution;
use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\TicketComment;
use App\Models\User;
use App\Services\TicketRules;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TicketController extends Controller
{
    public function __construct(private readonly TicketRules $ticketRules)
    {
    }

    public function index(Request $request): View
    {
        $user = Auth::user();
        $ticketsQuery = Ticket::with(['area', 'category', 'requester', 'assignedUser']);

        if (! $user->isStaff()) {
            $ticketsQuery->where('requester_id', $user->id);
        }

        if ($user->isStaff()) {
            $filters = $request->validate([
                'q' => ['nullable', 'string', 'max:160'],
                'status' => ['nullable', Rule::in($this->ticketRules->validStatuses())],
                'priority' => ['nullable', Rule::in($this->ticketRules->validPriorities())],
            ]);

            $ticketsQuery
                ->when($filters['q'] ?? null, function ($query, string $search): void {
                    $query->where(function ($query) use ($search): void {
                        $query
                            ->where('title', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%");
                    });
                })
                ->when($filters['status'] ?? null, fn ($query, string $status) => $query->where('status', $status))
                ->when($filters['priority'] ?? null, fn ($query, string $priority) => $query->where('priority', $priority));
        }

        $tickets = $ticketsQuery
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('tickets.index', [
            'tickets' => $tickets,
            'canSearch' => $user->isStaff(),
        ]);
    }

    public function create(): View
    {
        $user = Auth::user();

        return view('tickets.create', [
            'areas' => Area::orderBy('name')->get(),
            'categories' => TicketCategory::orderBy('name')->get(),
            'users' => $user->isStaff() ? User::orderBy('name')->get() : collect(),
            'canChooseRequester' => $user->isStaff(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $rules = [
            'title' => ['required', 'string', 'max:160'],
            'description' => ['required', 'string'],
            'area_id' => ['required', 'exists:areas,id'],
            'ticket_category_id' => ['required', 'exists:ticket_categories,id'],
            'priority' => ['required', Rule::in($this->ticketRules->validPriorities())],
        ];

        if ($user->isStaff()) {
            $rules['requester_id'] = ['required', 'exists:users,id'];
        }

        $validated = $request->validate($rules);

        $ticket = Ticket::create($validated + [
            'requester_id' => $user->isStaff() ? $validated['requester_id'] : $user->id,
            'status' => $this->ticketRules->initialStatus(),
        ]);

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('status', 'Ticket creado correctamente.');
    }

    public function show(Ticket $ticket): View
    {
        $this->authorizeView($ticket);

        $ticket->load([
            'area',
            'category',
            'requester',
            'assignedUser',
            'comments.user',
            'solution.user',
        ]);

        return view('tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket): View
    {
        $this->authorizeEdit($ticket);

        $ticket->load(['solution']);
        $user = Auth::user();

        return view('tickets.edit', [
            'ticket' => $ticket,
            'areas' => Area::orderBy('name')->get(),
            'categories' => TicketCategory::orderBy('name')->get(),
            'users' => User::orderBy('name')->get(),
            'canEditAll' => $user->isStaff(),
        ]);
    }

    public function update(Request $request, Ticket $ticket): RedirectResponse
    {
        $this->authorizeEdit($ticket);

        $user = Auth::user();

        if (! $user->isStaff()) {
            $validated = $request->validate([
                'title' => ['required', 'string', 'max:160'],
                'description' => ['required', 'string'],
            ]);

            $ticket->update($validated);

            return redirect()
                ->route('tickets.show', $ticket)
                ->with('status', 'Ticket actualizado correctamente.');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'description' => ['required', 'string'],
            'area_id' => ['required', 'exists:areas,id'],
            'ticket_category_id' => ['required', 'exists:ticket_categories,id'],
            'requester_id' => ['required', 'exists:users,id'],
            'assigned_user_id' => ['nullable', 'exists:users,id'],
            'status' => ['required', Rule::in($this->ticketRules->validStatuses())],
            'priority' => ['required', Rule::in($this->ticketRules->validPriorities())],
            'comment_body' => ['nullable', 'string'],
            'comment_is_internal' => ['nullable', 'boolean'],
            'solution_summary' => ['nullable', 'string', 'max:160'],
            'solution_details' => ['nullable', 'string'],
        ]);

        $ticket->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'area_id' => $validated['area_id'],
            'ticket_category_id' => $validated['ticket_category_id'],
            'requester_id' => $validated['requester_id'],
            'assigned_user_id' => $validated['assigned_user_id'] ?? null,
            'status' => $validated['status'],
            'priority' => $validated['priority'],
        ]);

        if (! empty($validated['comment_body'])) {
            TicketComment::create([
                'ticket_id' => $ticket->id,
                'user_id' => $user->id,
                'body' => $validated['comment_body'],
                'is_internal' => (bool) ($validated['comment_is_internal'] ?? false),
            ]);
        }

        if (! empty($validated['solution_summary']) || ! empty($validated['solution_details'])) {
            Solution::updateOrCreate(
                ['ticket_id' => $ticket->id],
                [
                    'user_id' => $user->id,
                    'summary' => $validated['solution_summary'] ?? '',
                    'details' => $validated['solution_details'] ?? '',
                ]
            );
        }

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('status', 'Ticket actualizado correctamente.');
    }

    private function authorizeView(Ticket $ticket): void
    {
        $user = Auth::user();

        abort_unless($this->ticketRules->canView($user, $ticket), 403);
    }

    private function authorizeEdit(Ticket $ticket): void
    {
        $user = Auth::user();

        abort_unless($this->ticketRules->canEdit($user, $ticket), 403);
    }
}
