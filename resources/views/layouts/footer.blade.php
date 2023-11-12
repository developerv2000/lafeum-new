<footer class="footer">
    <div class="footer__inner">
        <x-navbar class="footer__navbar" />

        <hr class="footer__seperator">

        <div class="footer__base">
            <x-logo class="footer__logo" />
            <p class="footer__site-desc">Научно–образовательный медиаресурс</p>

            <nav class="footer__terms-container">
                <a class="footer__terms-link" href="{{ route('policy') }}">Политика конфиденциальности</a>
                <a class="footer__terms-link" href="{{ route('terms-of-use') }}">Пользовательское соглашение</a>
            </nav>

            <a class="footer__contacts-link" href="{{ route('contacts') }}">Контакты</a>

            <div class="footer__socials">
                {{-- <a class="footer__socials-link" href="https://vk.com/club209177677" target="_blank">
                    <img class="footer__socials-image" src="{{ asset('img/main/vk.svg') }}" alt="vkontakte">
                </a> --}}

                <a class="footer__socials-link" href="https://t.me/lafeum_ru" target="_blank">
                    <img class="footer__socials-image" src="{{ asset('img/main/telegram.svg') }}" alt="telegram">
                </a>
            </div>
        </div>
    </div>

    <button class="scroll-top"><span class="material-symbols-outlined">arrow_upward</span></button>
    <p class="footer__copyright">© 2017 - 2023 — Lafeum. Все права защищены.</p>
</footer>
