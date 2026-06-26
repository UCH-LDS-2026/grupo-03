@extends('layouts.app')

@section('title', 'Soluciones - Sistema Tickets')

@section('content')
    <section class="page-header">
        <div>
            <h1>Soluciones</h1>
            <p class="muted">Documentación de soluciones registradas en tickets resueltos.</p>
        </div>
    </section>

    <form class="panel form filters" method="GET" action="{{ route('solutions.index') }}">
        <div class="field">
            <label for="q">Buscar</label>
            <input id="q" name="q" value="{{ request('q') }}" placeholder="Descripción, problema o solución">
        </div>

        <div class="field">
            <label for="area_id">Área</label>
            <select id="area_id" name="area_id">
                <option value="">Todas</option>
                @foreach ($areas as $area)
                    <option value="{{ $area->id }}" @selected((string) request('area_id') === (string) $area->id)>{{ $area->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="field">
            <label for="ticket_category_id">Categoría</label>
            <select id="ticket_category_id" name="ticket_category_id">
                <option value="">Todas</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected((string) request('ticket_category_id') === (string) $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <button class="button" type="submit">Buscar</button>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>Ticket</th>
                <th>Área</th>
                <th>Categoría</th>
                <th>Solución</th>
                <th>Registrada por</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($solutions as $solution)
                <tr>
                    <td>
                        <a href="{{ route('tickets.show', $solution->ticket) }}">#{{ $solution->ticket->id }} {{ $solution->ticket->title }}</a>
                    </td>
                    <td>{{ $solution->ticket->area->name }}</td>
                    <td>{{ $solution->ticket->category->name }}</td>
                    <td>
                        <strong>{{ $solution->summary }}</strong>
                        @if ($solution->details)
                            <p>{{ $solution->details }}</p>
                        @endif
                    </td>
                    <td>{{ $solution->user->name }}</td>
                    <td>{{ $solution->updated_at->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Todavía no hay soluciones registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 16px;">
        {{ $solutions->links('vendor.pagination.default') }}
    </div>
@endsection
