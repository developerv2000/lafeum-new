@extends('dashboard.layouts.app', [
    'breadcrumbs' => ['Фото', 'Редактировать', '#' . $item->id],

    'actions' => ['update', 'destroy'],
])

@section('main')
    <form class="form" id="edit-form" action="{{ route($modelPrefixName . '.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('dashboard.form.edit-components.id-input')
        @include('dashboard.form.edit-components.previous-url-input')

        @include('dashboard.form.edit-components.image-input', [
            'label' => 'Изображение',
            'name' => 'filename',
            'imageSrc' => asset('img/photos/thumbs/' . $item->filename),
            'required' => false,
        ])

        @include('dashboard.form.edit-components.textarea', [
            'label' => 'Описание',
            'name' => 'description',
            'required' => true,
        ])

        @include('dashboard.form.edit-components.multiple-select', [
            'label' => 'Категория',
            'name' => 'categories[]',
            'required' => true,
            'options' => $categories,
            'relationName' => 'categories',
            'valueColumnName' => 'id',
            'titleColumnName' => 'name',
        ])

        @include('dashboard.form.edit-components.date-time-input', [
            'label' => 'Дата публикации',
            'name' => 'publish_at',
            'required' => true,
        ])
    </form>

    @include('dashboard.modals.single-destroy', ['itemID' => $item->id])
@endsection
