<div class="main-card videos-card">
    {{-- Header --}}
    <div class="main-card__header">
        <div class="main-card__categories">
            @foreach ($video->categories as $cat)
                <a class="main-card__categories-link" href="{{ route('videos.index') }}?cats[]={{ $cat->id }}">#{{ $cat->name }}</a>
            @endforeach
        </div>

        <a class="main-card__id" href="{{ route('videos.show', $video->id) }}">#{{ $video->id }}</a>
    </div>

    {{-- Body --}}
    <div class="main-card__body">
        <img class="videos-card__image" src="{{ $video->thumbnail }}" alt="{{ $video->name }}">

        <div class="videos-card__text-container">
            <h5 class="main-card__title"><a href="{{ route('channels.show', $video->channel->slug) }}">{{ $video->channel->name }}</a></h5>
            <div class="main-card__text">{!! $video->title !!}</div>
        </div>

        <div class="videos-card__iframe-container" data-src="{{ $video->embed_link }}"></div>
    </div>

    {{-- Footer --}}
    <div class="main-card__footer">
        @auth
            <x-cards.partials.like-auth model="App\Models\Video" :item="$video" />
            <x-cards.partials.favorite-auth model="App\Models\Video" :item="$video" />
        @else
            <x-cards.partials.like-guest :item="$video" />
            <x-cards.partials.favorite-guest />
        @endauth

        <x-cards.partials.share url="{{ route('videos.show', $video->id) }}" />
    </div>
</div>
