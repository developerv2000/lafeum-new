@extends('auth.app')

@section('main')
    <img class="logo" src="{{ asset('img/main/logo-light.png') }}" alt="Lafeum logo">
    <h1 class="title">Сброс пароля</h1>

    <div class="box">
        <p class="desc">
            Придумайте новый надежный пароль для своего аккаунта, зарегистрированного по адресу <strong>{{ $request->email }}</strong>
        </p>

        <form class="form reset-password-form" action="{{ route('password.store') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            <input type="hidden" name="email" value="{{ $request->email }}">

            <div class="form-group">
                <label class="label" for="password">@error('password') Пароли не совпадают @enderror</label>
                <input class="input" type="password" name="password" id="password" autocomplete="new-password" placeholder="Введите новый пароль" minlength="5" required autofocus>
            </div>

            <div class="form-group">
                <label class="label" for="password_confirmation">@error('password') Пароли не совпадают @enderror</label>

                <input class="input" type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password" placeholder="Повторите новый пароль" minlength="5" required>
            </div>

            <x-button class="reset-password-form__button" style="dark" icon="lock_reset">
                Обновить пароль
            </x-button>
        </form>
    </div>
@endsection
