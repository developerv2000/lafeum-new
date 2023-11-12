<div class="cards-list terms-list">
    <script>
        subterms = {{ $subterms }};
    </script>

    @foreach ($terms as $term)
        <x-cards.terms :term="$term" />
    @endforeach

    @if ($terms->hasPages())
        {{ $terms->links('layouts.pagination') }}
    @endif
</div>
