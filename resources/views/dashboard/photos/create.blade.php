@extends('dashboard.layouts.app', [
    'breadcrumbs' => ['Фото', 'Добавить'],

    'actions' => ['store'],
])

@section('main')
    <form class="form" id="create-form" action="{{ route($modelPrefixName . '.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @include('dashboard.form.create-components.image-input', [
            'label' => 'Изображение',
            'name' => 'filename',
            'required' => true,
        ])

        @include('dashboard.form.create-components.textarea', [
            'label' => 'Описание',
            'name' => 'description',
            'required' => true,
        ])

        @include('dashboard.form.create-components.multiple-select', [
            'label' => 'Категория',
            'name' => 'categories[]',
            'required' => true,
            'options' => $categories,
            'valueColumnName' => 'id',
            'titleColumnName' => 'name',
        ])

        @include('dashboard.form.create-components.date-time-input', [
            'label' => 'Дата публикации',
            'name' => 'publish_at',
            'required' => true,
        ])
    </form>
@endsection
