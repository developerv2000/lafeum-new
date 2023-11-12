@extends('dashboard.layouts.app', [
    'breadcrumbs' => ['Цитаты', 'Редактировать', '#' . $item->id],

    'actions' => ['update', 'destroy'],
])

@section('main')
    <form class="form" id="edit-form" action="{{ route($modelPrefixName . '.update') }}" method="POST">
        @csrf
        @include('dashboard.form.edit-components.id-input')
        @include('dashboard.form.edit-components.previous-url-input')

        @include('dashboard.form.edit-components.single-select', [
            'label' => 'Автор',
            'name' => 'author_id',
            'required' => true,
            'options' => $authors,
            'relationName' => 'author',
            'valueColumnName' => 'id',
            'titleColumnName' => 'name',
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

        @include('dashboard.form.edit-components.wysiwyg-textarea', [
            'label' => 'Текст цитаты',
            'name' => 'body',
            'required' => true,
        ])

        @include('dashboard.form.edit-components.wysiwyg-textarea', [
            'label' => 'Мысли автора',
            'name' => 'notes',
            'required' => false,
        ])

        @include('dashboard.form.edit-components.date-time-input', [
            'label' => 'Дата публикации',
            'name' => 'publish_at',
            'required' => true,
        ])
    </form>

    @include('dashboard.modals.single-destroy', ['itemID' => $item->id])
@endsection
