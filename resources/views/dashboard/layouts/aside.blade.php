<aside class="aside thin-scrollbar">
    <nav class="navbar">
        {{-- Main Links --}}
        <ul class="menu">
            <li class="menu__item">
                <h3 class="menu__item-title">Основные</h3>
            </li>

            <div class="accordion menu__accordion">
                {{-- Quotes --}}
                <div class="accordion__item @if ($modelPrefixName == 'quotes') accordion__item--active accordion__item--highlight @endif">
                    <button class="accordion__button">
                        <span class="accordion__button-symbol material-symbols-outlined">format_quote</span>
                        <span class="accordion__button-text">Цитаты</span>
                        <span class="accordion__button-icon material-symbols-outlined">expand_more</span>
                    </button>

                    <div class="accordion__collapse">
                        <a class="accordion__collapse-link" href="{{ route('quotes.dashboard.index') }}">Все цитаты</a>
                        <a class="accordion__collapse-link" href="{{ route('quotes.dashboard.trash') }}">Корзина</a>
                    </div>
                </div>

                {{-- Termins --}}
                <div class="accordion__item @if ($modelPrefixName == 'terms' || $modelPrefixName == 'knowledge') accordion__item--active accordion__item--highlight @endif">
                    <button class="accordion__button">
                        <span class="accordion__button-symbol material-symbols-outlined">notes</span>
                        <span class="accordion__button-text">Термины</span>
                        <span class="accordion__button-icon material-symbols-outlined">expand_more</span>
                    </button>

                    <div class="accordion__collapse">
                        <a class="accordion__collapse-link" href="{{ route('terms.dashboard.index') }}">Все термины</a>
                        <a class="accordion__collapse-link" href="{{ route('terms.dashboard.trash') }}">Корзина</a>
                        <a class="accordion__collapse-link @if ($modelPrefixName == 'knowledge') accordion__collapse-link--active @endif" href="{{ route('knowledge.dashboard.index') }}">Область знаний</a>
                    </div>
                </div>

                {{-- Videos --}}
                <div class="accordion__item @if ($modelPrefixName == 'videos') accordion__item--active accordion__item--highlight @endif">
                    <button class="accordion__button">
                        <span class="accordion__button-symbol material-symbols-outlined">smart_display</span>
                        <span class="accordion__button-text">Видео</span>
                        <span class="accordion__button-icon material-symbols-outlined">expand_more</span>
                    </button>

                    <div class="accordion__collapse">
                        <a class="accordion__collapse-link" href="{{ route('videos.dashboard.index') }}">Все видео</a>
                        <a class="accordion__collapse-link" href="{{ route('videos.dashboard.trash') }}">Корзина</a>
                    </div>
                </div>

                {{-- Photos --}}
                <div class="accordion__item @if ($modelPrefixName == 'photos') accordion__item--active accordion__item--highlight @endif">
                    <button class="accordion__button">
                        <span class="accordion__button-symbol material-symbols-outlined">perm_media</span>
                        <span class="accordion__button-text">Фото</span>
                        <span class="accordion__button-icon material-symbols-outlined">expand_more</span>
                    </button>

                    <div class="accordion__collapse">
                        <a class="accordion__collapse-link" href="{{ route('photos.dashboard.index') }}">Все фото</a>
                        <a class="accordion__collapse-link" href="{{ route('photos.dashboard.trash') }}">Корзина</a>
                    </div>
                </div>

                {{-- Categories --}}
                <div class="accordion__item @if ($modelPrefixName == 'categories') accordion__item--active accordion__item--highlight @endif">
                    <button class="accordion__button">
                        <span class="accordion__button-symbol material-symbols-outlined">list</span>
                        <span class="accordion__button-text">Категории</span>
                        <span class="accordion__button-icon material-symbols-outlined">expand_more</span>
                    </button>

                    <div class="accordion__collapse">
                        <a class="accordion__collapse-link
                            @if ($modelPrefixName == 'categories' && request()->model == 'QuoteCategory') accordion__collapse-link--active @endif"
                            href="{{ route('categories.dashboard.index') }}?model=QuoteCategory">Цитаты</a>

                        <a class="accordion__collapse-link
                            @if ($modelPrefixName == 'categories' && request()->model == 'TermCategory') accordion__collapse-link--active @endif"
                            href="{{ route('categories.dashboard.index') }}?model=TermCategory">Термины</a>

                        <a class="accordion__collapse-link
                            @if ($modelPrefixName == 'categories' && request()->model == 'VideoCategory') accordion__collapse-link--active @endif"
                            href="{{ route('categories.dashboard.index') }}?model=VideoCategory">Видео</a>

                        <a class="accordion__collapse-link
                            @if ($modelPrefixName == 'categories' && request()->model == 'PhotoCategory') accordion__collapse-link--active @endif"
                            href="{{ route('categories.dashboard.index') }}?model=PhotoCategory">Фотографии</a>
                    </div>
                </div>

                {{-- Authors --}}
                <div class="accordion__item @if ($modelPrefixName == 'authors') accordion__item--active accordion__item--highlight @endif">
                    <button class="accordion__button">
                        <span class="accordion__button-symbol material-symbols-outlined">account_circle</span>
                        <span class="accordion__button-text">Авторы</span>
                        <span class="accordion__button-icon material-symbols-outlined">expand_more</span>
                    </button>

                    <div class="accordion__collapse">
                        <a class="accordion__collapse-link" href="{{ route('authors.dashboard.index') }}">Все авторы</a>
                        <a class="accordion__collapse-link" href="{{ route('authors.dashboard.trash') }}">Корзина</a>
                    </div>
                </div>

                {{-- Channels --}}
                <div class="accordion__item @if ($modelPrefixName == 'channels') accordion__item--active accordion__item--highlight @endif"">
                    <button class="accordion__button">
                        <span class="accordion__button-symbol material-symbols-outlined">video_library</span>
                        <span class="accordion__button-text">Каналы</span>
                        <span class="accordion__button-icon material-symbols-outlined">expand_more</span>
                    </button>

                    <div class="accordion__collapse">
                        <a class="accordion__collapse-link" href="{{ route('channels.dashboard.index') }}">Все каналы</a>
                        <a class="accordion__collapse-link" href="{{ route('channels.dashboard.trash') }}">Корзина</a>
                    </div>
                </div>
            </div>

            {{-- Users --}}
            <li class="menu__item">
            <a class="menu__link @if ($modelPrefixName == 'users') menu__link--active @endif" href="{{ route('users.dashboard.index') }}">
                    <span class="material-symbols-outlined">group</span> Пользователи
                </a>
            </li>

            {{-- Feedbacks --}}
            <li class="menu__item">
                <a class="menu__link @if ($modelPrefixName == 'feedbacks') menu__link--active @endif" href="{{ route('feedbacks.dashboard.index') }}">
                    <span class="material-symbols-outlined">chat</span> Обратная связь
                </a>
            </li>
        </ul>

        {{-- Additional Links --}}
        <ul class="menu">
            <li class="menu__item">
                <h3 class="menu__item-title">Дополнительно</h3>
            </li>

            <li class="menu__item">
                <a class="menu__link" href="{{ route('home') }}" target="_blank">
                    <span class="material-symbols-outlined">home</span> Перейти на сайт
                </a>
            </li>

            <li class="menu__item">
                <form class="menu__form" method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button class="menu__form-button">
                        <span class="material-symbols-outlined">exit_to_app</span> Выйти
                    </button>
                </form>
            </li>
        </ul>
    </nav>
</aside>
