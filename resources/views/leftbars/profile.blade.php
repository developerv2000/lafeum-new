<aside class="leftbar profile-leftbar">
    <div class="leftbar__inner">
        <h2 class="main-title leftbar__title">Мой аккаунт</h2>
        <p class="profile-leftbar__subtitle">Основные </p>

        <nav class="profile-leftbar__nav">
            <a class="profile-leftbar__link" href="{{ route('profile.edit') }}">
                <span class="material-symbols-outlined">person</span> Настройки профиля
            </a>

            <a class="profile-leftbar__link" href="{{ route('likes.index') }}">
                <span class="material-symbols-outlined">favorite</span> Мои лайки
            </a>

            <a class="profile-leftbar__link" href="{{ route('favorites.index') }}">
                <span class="material-symbols-outlined">bookmark</span> Мои избранные
            </a>

            <div class="profile-leftbar__folders">
                @foreach ($user->rootFolders as $folder)
                    <div class="profile-leftbar__folders-item">
                        <a class="profile-leftbar__link" href="{{ route('folders.show', $folder->id) }}">
                            <svg class="profile-leftbar__link-svg"><use href="#folder-svg"></use></svg> {{ $folder->name }}
                        </a>

                        @if ($folder->childs->count())
                            <div class="profile-leftbar__folders-childs">
                                @foreach ($folder->childs as $child)
                                    <a class="profile-leftbar__link" href="{{ route('folders.show', $child->id) }}">
                                        <svg class="profile-leftbar__link-svg"><use href="#subfolder-svg"></use></svg> {{ $child->name }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </nav>

        <form class="profile-leftbar__logout" action="{{ route('logout') }}" method="POST">
            @csrf

            <button class="profile-leftbar__button">
                <span class="material-symbols-outlined">power_rounded</span> Выход
            </button>
        </form>
    </div>
</aside>
