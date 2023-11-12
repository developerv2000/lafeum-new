@extends('dashboard.layouts.app', [
    'breadcrumbs' => ['Авторы', 'Добавить'],

    'actions' => ['store'],
])

@section('main')
    <form class="form" id="create-form" action="{{ route($modelPrefixName . '.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @include('dashboard.form.create-components.text-input', [
            'label' => 'Имя',
            'name' => 'name',
            'required' => true,
        ])

        @include('dashboard.form.create-components.image-input', [
            'label' => 'Изображение',
            'name' => 'photo',
            'required' => true,
        ])

        @include('dashboard.form.create-components.wysiwyg-textarea', [
            'label' => 'Биография',
            'name' => 'biography',
            'required' => false,
        ])

        @include('dashboard.form.create-components.single-select', [
            'label' => 'Группа',
            'name' => 'group_id',
            'required' => true,
            'options' => $groups,
            'valueColumnName' => 'id',
            'titleColumnName' => 'name',
        ])

    </form>
@endsection
