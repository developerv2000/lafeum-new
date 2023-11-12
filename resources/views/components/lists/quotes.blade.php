<div class="quotes-list cards-list">
    @foreach ($quotes as $quote)
        <x-cards.quotes :quote="$quote" />
    @endforeach

    @if($quotes->hasPages())
        {{ $quotes->links('layouts.pagination') }}
    @endif
</div>
