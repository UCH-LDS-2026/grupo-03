<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TicketCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TicketCategoryController extends Controller
{
    public function index(): View
    {
        $this->authorizeAdmin();

        return view('admin.categories.index', [
            'categories' => TicketCategory::orderBy('name')->paginate(10),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeAdmin();

        TicketCategory::create($request->validate([
            'name' => ['required', 'string', 'max:120', 'unique:ticket_categories,name'],
            'description' => ['nullable', 'string'],
        ]));

        return redirect()->route('admin.categories.index')->with('status', 'Categoría creada correctamente.');
    }

    public function edit(TicketCategory $category): View
    {
        $this->authorizeAdmin();

        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, TicketCategory $category): RedirectResponse
    {
        $this->authorizeAdmin();

        $category->update($request->validate([
            'name' => ['required', 'string', 'max:120', Rule::unique('ticket_categories')->ignore($category)],
            'description' => ['nullable', 'string'],
        ]));

        return redirect()->route('admin.categories.index')->with('status', 'Categoría actualizada correctamente.');
    }

    private function authorizeAdmin(): void
    {
        abort_unless(Auth::user()?->isAdmin(), 403);
    }
}
