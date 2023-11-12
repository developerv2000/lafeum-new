@extends('layouts.app', ['pageClass' => 'profile-edit'])

@section('leftbar')
    @include('leftbars.profile')
@endsection

@section('main')
    <section class="profile-edit__main">
        <div class="about profile-edit__main-about">
            <h1 class="main-title about__title">Основные настройки</h1>
            <div class="about__desc">Немного текста про этот раздел. Что тут может посетитель просмотреть</div>
        </div>

        <form class="form profile-form" action="{{ route('profile.update') }}" method="POST" data-on-submit="show-spinner" enctype="multipart/form-data">
            @csrf

            <div class="profile-form__ava-container">
                <label class="profile-form__ava-label">
                    <img class="profile-form__ava-image" src="{{ asset('img/users/' . $user->photo) }}" alt="ava">
                    <input class="visually-hidden profile-form__ava-input" type="file" name="photo" accept=".png, .jpg, .jpeg">
                </label>

                <div class="profile-form__ava-edit-btn">
                    <span class="material-symbols-outlined">edit</span>
                </div>
            </div>

            <x-form.group-validated input-name="name">
                <input class="input" type="text" name="name" placeholder="Ваше имя*" value="{{ old('name', $user->name) }}" required>
            </x-form.group-validated>

            <x-form.group-validated input-name="email">
                <input class="input" type="email" name="email" placeholder="Ваша почта*" value="{{ old('email', $user->email) }}" required>
            </x-form.group-validated>

            <x-form.group>
                <select class="select" name="country_id">
                    <option value="" @selected(!$user->country_id)>Выберите страну</option>

                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}" @selected($country->id == $user->country_id)>{{ $country->name }}</option>
                    @endforeach
                </select>
            </x-form.group>

            <x-form.group>
                <input class="input" type="date" name="birthday" placeholder="День рождения*" value="{{ old('birthday', $user->birthday) }}">
            </x-form.group>

            <x-form.group>
                <select class="select" name="gender_id">
                    <option value="" @selected(!$user->gender_id)>Выберите пол</option>

                    @foreach ($genders as $gender)
                        <option value="{{ $gender->id }}" @selected($gender->id == $user->gender_id)>{{ $gender->name }}</option>
                    @endforeach
                </select>
            </x-form.group>

            <x-form.group>
                <textarea class="textarea" name="biography" placeholder="Коротко о вас">{{ old('biography', $user->biography) }}</textarea>
            </x-form.group>

            <x-button class="profile-form__button" style="dark" icon="edit_note">
                Сохранить
            </x-button>
        </form>
    </section>

    <section class="profile-edit__password" id="password-update-section">
        <div class="about profile-edit__password-about">
            <h1 class="main-title about__title">Смена пароля</h1>
            <div class="about__desc">Немного текста про этот раздел. Что тут может посетитель просмотреть</div>
        </div>

        <form class="form profile-form" action="{{ route('password.update') }}" method="POST" data-on-submit="show-spinner">
            @csrf

            <x-form.group-validated input-name="current_password">
                <input class="input" type="password" name="current_password" placeholder="Введите старый пароль*" autocomplete="current-password" minlength="5" required>
            </x-form.group-validated>

            <x-form.group-validated input-name="password">
                <input class="input" type="password" name="password" placeholder="Введите новый пароль*" autocomplete="new-password" minlength="5" required>
            </x-form.group-validated>

            <x-button class="profile-form__button" style="dark" icon="lock_reset">
                Обновить
            </x-button>
        </form>
    </section>
@endsection
