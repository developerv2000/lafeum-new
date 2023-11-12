<div class="modal auth-modal login-modal">
    <div class="modal__background"></div>
    <div class="modal__box">
        <div class="modal__header">
            <h6 class="main-title modal__title">Вход</h6>
            <p class="modal__desc">Добро пожаловать, <br>мы ждали Вас !</p>
        </div>

        <div class="modal__body">
            <form class="form auth-form login-form" action="/login" id="login-form">
                @csrf

                <x-form.group>
                    <input class="input" type="email" name="email" placeholder="Введите Ваш Email*" required>
                </x-form.group>

                <x-form.group>
                    <input class="input" type="password" name="password" placeholder="Введите Ваш Пароль*" autocomplete="current-password" minlength="5" required>
                </x-form.group>

                <div class="login-form__row">
                    <x-show-modal-button class="login-form__register" style="transparent" target=".register-modal">
                        У Вас нет аккаунта?
                    </x-show-modal-button>

                    <x-show-modal-button class="login-form__register" style="transparent" target=".forgot-password-modal">
                        Забыли пароль?
                    </x-show-modal-button>
                </div>

                <x-button class="auth-button login-form__submit" style="dark" icon="login">
                    Вход
                </x-button>
            </form>
        </div>
    </div>
</div>
