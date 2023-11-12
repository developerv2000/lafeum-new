@extends('dashboard.layouts.app', [
    'breadcrumbs' => ['Авторы', 'Редактировать', '#' . $item->id],

    'actions' => ['update', 'destroy'],
])

@section('main')
    <form class="form" id="edit-form" action="{{ route($modelPrefixName . '.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('dashboard.form.edit-components.id-input')
        @include('dashboard.form.edit-components.previous-url-input')

        @include('dashboard.form.edit-components.text-input', [
            'label' => 'Имя',
            'name' => 'name',
            'required' => true,
        ])

        @include('dashboard.form.edit-components.image-input', [
            'label' => 'Изображение',
            'name' => 'photo',
            'imageSrc' => asset('img/authors/' . $item->photo),
            'required' => false,
        ])

        @include('dashboard.form.edit-components.wysiwyg-textarea', [
            'label' => 'Биография',
            'name' => 'biography',
            'required' => false,
        ])

        @include('dashboard.form.edit-components.single-select', [
            'label' => 'Группа',
            'name' => 'group_id',
            'required' => true,
            'options' => $groups,
            'relationName' => 'group',
            'valueColumnName' => 'id',
            'titleColumnName' => 'name',
        ])
    </form>

    @include('dashboard.modals.single-destroy', ['itemID' => $item->id])
@endsection
