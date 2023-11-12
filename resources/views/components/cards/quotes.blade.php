<div class="main-card quotes-card">
    {{-- Header --}}
    <div class="main-card__header">
        <div class="main-card__categories">
            @foreach ($quote->categories as $cat)
                <a class="main-card__categories-link" href="{{ route('quotes.index') }}?cats[]={{ $cat->id }}">#{{ $cat->name }}</a>
            @endforeach
        </div>

        <a class="main-card__id" href="{{ route('quotes.show', $quote->id) }}">#{{ $quote->id }}</a>
    </div>

    {{-- Body --}}
    <div class="main-card__body">
        <h5 class="main-card__title"><a href="{{ route('authors.show', $quote->author->slug) }}">{{ $quote->author->name }}</a></h5>

        @if ($quote->notes)
            <div class="quotes-card__notes">{!! $quote->notes !!}</div>
        @endif

        <div class="main-card__text">{!! $quote->body !!}</div>

        <x-cards.partials.expand-more />
    </div>

    {{-- Footer --}}
    <div class="main-card__footer">
        @auth
            <x-cards.partials.like-auth model="App\Models\Quote" :item="$quote" />
            <x-cards.partials.favorite-auth model="App\Models\Quote" :item="$quote" />
        @else
            <x-cards.partials.like-guest :item="$quote" />
            <x-cards.partials.favorite-guest />
        @endauth

        <x-cards.partials.share url="{{ route('quotes.show', $quote->id) }}" />
    </div>
</div>
