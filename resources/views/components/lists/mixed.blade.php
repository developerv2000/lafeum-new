<div class="mixed-list cards-list">
    <script>
        subterms = {{ $subterms }};
    </script>

    @foreach ($items as $item)
        @switch(get_class($item))
            @case('App\Models\Quote')
                <x-cards.quotes :quote="$item" />
            @break

            @case('App\Models\Term')
                <x-cards.terms :term="$item" />
            @break

            @case('App\Models\Video')
                <x-cards.videos :video="$item" />
            @break

            @case('App\Models\Photo')
                <x-cards.photos :photo="$item" />
            @break

            @default
        @endswitch
    @endforeach

    @if ($items->hasPages())
        {{ $items->links('layouts.pagination') }}
    @endif

    @unless (count($items))
        <p>Здесь пока пусто...</p>
    @endunless
</div>
