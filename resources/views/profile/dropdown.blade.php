<div class="dropdown profile-dropdown">
    <button class="dropdown__button">
        Мой профиль
        <span class="material-symbols-outlined">expand_more</span>
    </button>

    <div class="dropdown__content">
        <img class="profile-dropdown__ava" src="{{ asset('img/users/' . request()->user()->photo) }}" alt="ava">
        <p class="profile-dropdown__name">{{ request()->user()->name }}</p>

        <nav class="profile-dropdown__nav">
            @if (request()->user()->isAdmin())
                <a class="profile-dropdown__nav-link" href="{{ route('quotes.dashboard.index') }}">
                    <span class="material-symbols-outlined">settings</span>
                    Перейти на админку
                </a>
            @endif

            <a class="profile-dropdown__nav-link" href="{{ route('profile.edit') }}">
                <span class="material-symbols-outlined">person</span>
                Настройки профиля
            </a>

            <a class="profile-dropdown__nav-link" href="{{ route('likes.index') }}">
                <span class="material-symbols-outlined">favorite</span>
                Мои лайки
            </a>

            <a class="profile-dropdown__nav-link" href="{{ route('favorites.index') }}">
                <span class="material-symbols-outlined">bookmark</span>
                Мои избранные
            </a>

            <form class="profile-dropdown__nav-form" action="{{ route('logout') }}" method="POST">
                @csrf

                <button class="profile-dropdown__nav-button">
                    <span class="material-symbols-outlined">power_rounded</span>
                    Выход
                </button>
            </form>
        </nav>
    </div>
</div>
