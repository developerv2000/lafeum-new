<div class="main-card photos-card">
    {{-- Header --}}
    <div class="main-card__header">
        <div class="main-card__categories">
            @foreach ($photo->categories as $cat)
                <a class="main-card__categories-link" href="{{ route('photos.index') }}?cats[]={{ $cat->id }}">#{{ $cat->name }}</a>
            @endforeach
        </div>

        <a class="main-card__id" href="{{ route('photos.show', $photo->id) }}">#{{ $photo->id }}</a>
    </div>

    {{-- Body --}}
    <div class="main-card__body">
        <div class="main-card__text">{!! $photo->description !!}</div>
        <img class="photos-card__image" loading="lazy" src="{{ asset('img/photos/' . $photo->filename) }}" alt="photo">
    </div>

    {{-- Footer --}}
    <div class="main-card__footer">
        @auth
            <x-cards.partials.like-auth model="App\Models\Photo" :item="$photo" />
            <x-cards.partials.favorite-auth model="App\Models\Photo" :item="$photo" />
        @else
            <x-cards.partials.like-guest :item="$photo" />
            <x-cards.partials.favorite-guest />
        @endauth

        <x-cards.partials.share url="{{ route('photos.show', $photo->id) }}" />
    </div>
</div>
