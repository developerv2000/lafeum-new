<nav {{ $attributes->merge(['class' => 'navbar']) }}>
    <a class="navbar__link @if ($request->routeIs('knowledge.*')) navbar__link--active @endif" href="{{ route('knowledge.index') }}">
        <span class="navbar__link-icon material-symbols-outlined">library_books</span>
        <span class="navbar__link-text">Области знаний</span>
    </a>

    <a class="navbar__link @if ($request->routeIs('vocabulary.*')) !== false) navbar__link--active @endif" href="{{ route('vocabulary.index') }}">
        <span class="navbar__link-icon material-symbols-outlined">translate</span>
        <span class="navbar__link-text">Словарь</span>
    </a>

    <a class="navbar__link @if ($request->routeIs('quotes.*')) !== false) navbar__link--active @endif" href="{{ route('quotes.index') }}">
        <span class="navbar__link-icon material-symbols-outlined">format_quote</span>
        <span class="navbar__link-text">Цитаты</span>
    </a>

    <a class="navbar__link @if ($request->routeIs('authors.*')) !== false) navbar__link--active @endif" href="{{ route('authors.index') }}">
        <span class="navbar__link-icon material-symbols-outlined">group</span>
        <span class="navbar__link-text">Авторы</span>
    </a>

    <a class="navbar__link @if ($request->routeIs('videos.*')) !== false) navbar__link--active @endif" href="{{ route('videos.index') }}">
        <span class="navbar__link-icon material-symbols-outlined">smart_display</span>
        <span class="navbar__link-text">Видео</span>
    </a>

    <a class="navbar__link @if ($request->routeIs('channels.*')) !== false) navbar__link--active @endif" href="{{ route('channels.index') }}">
        <span class="navbar__link-icon material-symbols-outlined">video_library</span>
        <span class="navbar__link-text">Каналы</span>
    </a>

    <a class="navbar__link @if ($request->routeIs('terms.*')) !== false) navbar__link--active @endif" href="{{ route('terms.index') }}">
        <span class="navbar__link-icon material-symbols-outlined">description</span>
        <span class="navbar__link-text">Термины</span>
    </a>

    <a class="navbar__link @if ($request->routeIs('photos.*')) !== false) navbar__link--active @endif" href="{{ route('photos.index') }}">
        <span class="navbar__link-icon material-symbols-outlined">photo_camera</span>
        <span class="navbar__link-text">Фотографии</span>
    </a>
</nav>
