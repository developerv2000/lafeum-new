<aside class="rightbar">
    <div class="rightbar__inner">
        <h2 class="main-title rightbar__title">Материалы дня</h2>

        <div class="daily-posts">
            {{-- Quote --}}
            <div class="daily-posts__item daily-posts__item--quote">
                <h4 class="daily-posts__title">
                    <span class="daily-posts__title-text">Цитата дня</span>

                    <a class="daily-posts__title-link" href="{{ route('quotes.index') }}">
                        Все <span class="material-symbols-outlined">east</span>
                    </a>
                </h4>

                <div class="daily-posts__card">
                    <img class="daily-posts__card-image" src="{{ asset('img/authors/' . $daily->quote->author->photo) }}" alt="author">
                    <h5 class="daily-posts__card-title">{{ $daily->quote->author->name }}</h5>
                    <div class="daily-posts__card-text">{!! $daily->quote->body !!}</div>
                    <a class="daily-posts__more-btn" href="{{ route('quotes.show', $daily->quote->id) }}">Подробнее...</a>
                </div>
            </div>

            {{-- Term --}}
            <div class="daily-posts__item daily-posts__item--term">
                <h4 class="daily-posts__title">
                    <span class="daily-posts__title-text">Термин дня</span>

                    <a class="daily-posts__title-link" href="{{ route('terms.index') }}">
                        Все <span class="material-symbols-outlined">east</span>
                    </a>
                </h4>

                <div class="daily-posts__card">
                    <div class="daily-posts__card-text">{!! $daily->term->body !!}</div>
                    <a class="daily-posts__more-btn" href="{{ route('terms.show', $daily->term->id) }}">Подробнее...</a>
                </div>
            </div>

            {{-- Video --}}
            <div class="daily-posts__item daily-posts__item--video">
                <h4 class="daily-posts__title">
                    <span class="daily-posts__title-text">Видео дня</span>

                    <a class="daily-posts__title-link" href="{{ route('videos.index') }}">
                        Все <span class="material-symbols-outlined">east</span>
                    </a>
                </h4>

                <div class="daily-posts__card">
                    <img class="daily-posts__card-image" src="{{ $daily->video->thumbnail }}" alt="video">
                    <h5 class="daily-posts__card-title">{{ $daily->video->channel->name }}</h5>
                    <div class="daily-posts__card-text">{!! $daily->video->title !!}</div>
                </div>
            </div>

            {{-- Photo --}}
            <div class="daily-posts__item daily-posts__item--photo">
                <h4 class="daily-posts__title">
                    <span class="daily-posts__title-text">Фото дня</span>

                    <a class="daily-posts__title-link" href="{{ route('photos.index') }}">
                        Все <span class="material-symbols-outlined">east</span>
                    </a>
                </h4>

                <div class="daily-posts__card">
                    <img class="daily-posts__card-image" src="{{ asset('img/photos/thumbs/' . $daily->photo->filename) }}" alt="photo" data-action="show-modal" data-modal-target=".rightbar-photo-modal">
                    <div class="daily-posts__card-text">{!! $daily->photo->description !!}</div>
                </div>
            </div>
        </div>
    </div>

    @include('modals.rightbar.video')
    @include('modals.rightbar.photo')
</aside>
