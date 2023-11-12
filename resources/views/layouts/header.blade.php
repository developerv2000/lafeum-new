<header class="header">
    <div class="header__inner">
        <x-logo class="header__logo" />
        <x-navbar class="header__navbar" />

        @auth
            @include('profile.dropdown')
        @else
            <x-show-modal-button class="header__button" style="light" icon="input" target=".login-modal">
                Вход
            </x-show-modal-button>
        @endauth
    </div>
</header>
