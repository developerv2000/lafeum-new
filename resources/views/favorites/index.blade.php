@extends('layouts.app', ['pageClass' => 'favorites-index'])

@section('leftbar')
    @include('leftbars.profile')
@endsection

@section('main')
    <section class="favorites-index__about about">
        <h1 class="main-title about__title">Мои избранные</h1>
        <div class="about__desc">Немного текста про этот раздел. Что тут может посетитель просмотреть</div>
    </section>

    <section class="create-folder" id="create-folder">
        <h3 class="favorites__subtitle">Создать новую папку</h3>

        <form class="create-folder__form form" action="{{ route('folders.store') }}" method="POST" data-on-submit="show-spinner">
            @csrf

            <x-form.group>
                <input class="input" type="text" name="name" placeholder="Имя папки" required>
            </x-form.group>

            <x-form.group>
                <select class="select" name="parent_id">
                    <option value="">Без родителя</option>
                    @foreach ($rootFolders as $folder)
                        <option value="{{ $folder->id }}">{{ $folder->name }}</option>
                    @endforeach
                </select>
            </x-form.group>

            <x-button class="create-folder__submit" style="dark" icon="check">
                Сохранить
            </x-button>
        </form>
    </section>

    <section class="folders-section">
        <h3 class="favorites__subtitle">Список всех папок и подпапок</h3>

        <x-lists.folders :root-folders="$rootFolders" />
    </section>
@endsection
