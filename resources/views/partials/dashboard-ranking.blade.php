@forelse ($items as $item)
    <div class="ranking-row">
        <div class="ranking-info">
            <span>{{ $item['label'] }}</span>
            <strong>{{ $item['value'] }}</strong>
        </div>
        <div class="ranking-track" aria-hidden="true">
            <span style="width: {{ $item['percent'] }}%;"></span>
        </div>
    </div>
@empty
    <p class="muted">Todavía no hay datos suficientes.</p>
@endforelse
