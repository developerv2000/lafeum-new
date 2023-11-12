@extends('auth.app')

@section('main')
    <img class="logo" src="{{ asset('img/main/logo-light.png') }}" alt="Lafeum logo">
    <h1 class="title">Спасибо за регистрацию</h1>

    <div class="box">
        <p class="desc">
            Прежде чем начать, не могли бы Вы подтвердить свой адрес электронной почты, перейдя по ссылке, которую мы только что отправили Вам по электронной почте? Если Вы не получили
            электронное письмо, мы с радостью вышлем Вам другое
        </p>

        <form class="form verification-send-form" action="{{ route('verification.send') }}" method="POST">
            @csrf
            <button class="button button--dark">
                <span class="material-symbols-outlined">mark_email_read</span>
                Выслать повторно
            </button>
        </form>

        <form class="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf

            <x-button class="logout-form__button" style="transparent">
                Выйти из аккаунта
            </x-button>
        </form>
    </div>
@endsection
