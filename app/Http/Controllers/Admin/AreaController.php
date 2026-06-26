<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AreaController extends Controller
{
    public function index(): View
    {
        $this->authorizeAdmin();

        return view('admin.areas.index', [
            'areas' => Area::orderBy('name')->paginate(10),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeAdmin();

        Area::create($request->validate([
            'name' => ['required', 'string', 'max:120', 'unique:areas,name'],
            'description' => ['nullable', 'string'],
        ]));

        return redirect()->route('admin.areas.index')->with('status', 'Área creada correctamente.');
    }

    public function edit(Area $area): View
    {
        $this->authorizeAdmin();

        return view('admin.areas.edit', compact('area'));
    }

    public function update(Request $request, Area $area): RedirectResponse
    {
        $this->authorizeAdmin();

        $area->update($request->validate([
            'name' => ['required', 'string', 'max:120', Rule::unique('areas')->ignore($area)],
            'description' => ['nullable', 'string'],
        ]));

        return redirect()->route('admin.areas.index')->with('status', 'Área actualizada correctamente.');
    }

    private function authorizeAdmin(): void
    {
        abort_unless(Auth::user()?->isAdmin(), 403);
    }
}
