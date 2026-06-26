<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Solution;
use App\Models\TicketCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolutionController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = Auth::user();

        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:160'],
            'area_id' => ['nullable', 'exists:areas,id'],
            'ticket_category_id' => ['nullable', 'exists:ticket_categories,id'],
        ]);

        $solutionsQuery = Solution::with(['ticket.area', 'ticket.category', 'ticket.requester', 'user'])
            ->whereHas('ticket', function ($query) use ($user, $filters): void {
                if (! $user->isStaff()) {
                    $query->where('requester_id', $user->id);
                }

                $query
                    ->when($filters['area_id'] ?? null, fn ($query, string $areaId) => $query->where('area_id', $areaId))
                    ->when($filters['ticket_category_id'] ?? null, fn ($query, string $categoryId) => $query->where('ticket_category_id', $categoryId));
            })
            ->when($filters['q'] ?? null, function ($query, string $search): void {
                $query->where(function ($query) use ($search): void {
                    $query
                        ->where('summary', 'like', "%{$search}%")
                        ->orWhere('details', 'like', "%{$search}%")
                        ->orWhereHas('ticket', function ($query) use ($search): void {
                            $query
                                ->where('title', 'like', "%{$search}%")
                                ->orWhere('description', 'like', "%{$search}%");
                        });
                });
            });

        $solutions = $solutionsQuery
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('solutions.index', [
            'solutions' => $solutions,
            'areas' => Area::orderBy('name')->get(),
            'categories' => TicketCategory::orderBy('name')->get(),
        ]);
    }
}
