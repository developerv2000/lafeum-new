<div class="modal auth-modal forgot-password-modal">
    <div class="modal__background"></div>
    <div class="modal__box">
        <div class="modal__header">
            <h6 class="main-title modal__title">Восстановление пароля</h6>
            <p class="modal__desc">Забыли пароль? Без проблем. Просто сообщите нам свой адрес электронной почты, и мы отправим вам ссылку для сброса пароля, которая позволит вам выбрать новый.</p>
        </div>

        <div class="modal__body">
            <form class="form auth-form forgot-password-form" action="{{ route('password.email') }}" id="forgot-password-form">
                @csrf

                <x-form.group>
                    <input class="input" type="email" name="email" placeholder="Введите Ваш Email*" required>
                </x-form.group>

                <x-button class="auth-button forgot-password-form__submit" style="dark" icon="mark_email_read">
                    Отправить
                </x-button>

                <x-show-modal-button class="auth-form__return-btn" style="transparent" target=".login-modal" icon="west">
                    Назад
                </x-show-modal-button>
            </form>
        </div>
    </div>
</div>
