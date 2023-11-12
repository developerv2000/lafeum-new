<div class="modal auth-modal register-modal">
    <div class="modal__background"></div>
    <div class="modal__box">
        <div class="modal__header">
            <h6 class="main-title modal__title">Регистрация</h6>
            <p class="modal__desc">Немного описания для чего нужна регистрация</p>
        </div>

        <div class="modal__body">
            <form class="form auth-form register-form" action="/register" id="register-form">
                @csrf

                <x-form.group>
                    <input class="input" type="text" name="name" placeholder="Как Вас зовут?*" required>
                </x-form.group>

                <x-form.group>
                    <input class="input" type="email" name="email" placeholder="Введите Ваш Email*" required>
                </x-form.group>

                <x-form.group>
                    <input class="input" type="password" name="password" placeholder="Введите Ваш пароль*" autocomplete="new-password" minlength="5" required>
                </x-form.group>

                <x-form.group>
                    <input class="input" type="password" name="password_confirmation" placeholder="Повторите пароль*" autocomplete="new-password" minlength="5" required>
                </x-form.group>

                <x-button class="auth-button login-form__submit" style="dark" icon="login">
                    Регистрация
                </x-button>

                <x-show-modal-button class="auth-form__return-btn" style="transparent" target=".login-modal" icon="west">
                    Назад
                </x-show-modal-button>
            </form>
        </div>
    </div>
</div>
