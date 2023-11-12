@extends('layouts.app', ['pageClass' => 'contacts-page'])

@section('main')
    <section class="about contacts-index__about">
        <h1 class="main-title about__title">Контакты</h1>
        <div class="about__desc">
            Мы рады, что Вы посетили наш сайт и ознакомились с находящейся на нем информацией. Вся информация находится в свободном доступе и предназначена только для частного пользования. Если Вы считаете, что Ваша работа была размещена на нашем сайте в нарушение Вашего авторского права, сообщите нам об этом, используя обратную связь. Будем рады рассмотреть Ваши рекомендации по усовершенствованию сайта.
        </div>
    </section>

    <section class="feedback">
        <form class="form feedback__form" action="{{ route('feedbacks.store') }}" method="POST" data-on-submit="show-spinner">
            @csrf

            <h2 class="main-title feedback__title">Свяжитесь с Нами</h2>

            <x-form.group>
                <input class="input" type="text" name="name" placeholder="Ваше имя*" required>
            </x-form.group>

            <x-form.group>
                <input class="input" type="email" name="email" placeholder="Ваша почта*" required>
            </x-form.group>

            <x-form.group>
                <input class="input" type="text" name="topic" placeholder="Тема обращения">
            </x-form.group>

            <x-form.group>
                <input class="input" type="text" name="message" placeholder="Текст обращения*" required>
            </x-form.group>

            <x-button class="feedback__button" style="dark" icon="mail">
                Отправить
            </x-button>
        </form>
    </section>

    <section class="contacts-email">
        <h2 class="main-title contacts-email__title">Электронная почта:</h2>
        <p><a href="mailto:info@lafeum.ru">info@lafeum.ru</a></p>
    </section>
@endsection
