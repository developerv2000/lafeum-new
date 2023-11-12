<div class="main-card terms-card">
    {{-- Header --}}
    <div class="main-card__header">
        <div class="main-card__categories">
            @foreach ($term->categories as $cat)
                <a class="main-card__categories-link" href="{{ route('terms.index') }}">#{{ $cat->name }}</a>
            @endforeach
        </div>

        <a class="main-card__id" href="{{ route('terms.show', $term->id) }}">#{{ $term->id }}</a>
    </div>

    {{-- Body --}}
    <div class="main-card__body">
        <h5 class="main-card__title">{{ $term->type->name }}</h5>

        <div class="main-card__text terms-card__text">{!! $term->body !!}</div>

        <x-cards.partials.expand-more />

        {{-- Subterms Popup --}}
        <div class="terms-card__popup">
            <div class="terms-card__popup-inner"></div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="main-card__footer">
        @auth
            <x-cards.partials.like-auth model="App\Models\Term" :item="$term" />
            <x-cards.partials.favorite-auth model="App\Models\Term" :item="$term" />
        @else
            <x-cards.partials.like-guest :item="$term" />
            <x-cards.partials.favorite-guest />
        @endauth

        <x-cards.partials.share url="{{ route('terms.show', $term->id) }}" />
    </div>
</div>
