@extends('dashboard.layouts.app', [
    'breadcrumbs' => ['Термины', 'Редактировать', '#' . $item->id],

    'actions' => ['update', 'destroy'],
])

@section('main')
    <form class="form" id="edit-form" action="{{ route($modelPrefixName . '.update') }}" method="POST">
        @csrf
        @include('dashboard.form.edit-components.id-input')
        @include('dashboard.form.edit-components.previous-url-input')

        @include('dashboard.form.edit-components.text-input', [
            'label' => 'Название (Словарь)',
            'name' => 'name',
            'required' => false,
        ])

        @include('dashboard.form.edit-components.wysiwyg-textarea', [
            'label' => 'Термин',
            'name' => 'body',
            'required' => true,
        ])

        @include('dashboard.form.edit-components.boolean-radios', [
            'label' => 'Отображать в словаре ?',
            'name' => 'show_in_vocabulary',
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

        @include('dashboard.form.edit-components.multiple-select', [
            'label' => 'Область знаний',
            'name' => 'knowledges[]',
            'required' => true,
            'options' => $knowledges,
            'relationName' => 'knowledges',
            'valueColumnName' => 'id',
            'titleColumnName' => 'name',
        ])

        @include('dashboard.form.edit-components.single-select', [
            'label' => 'Тип',
            'name' => 'type_id',
            'required' => true,
            'options' => $types,
            'relationName' => 'type',
            'valueColumnName' => 'id',
            'titleColumnName' => 'name',
        ])

        @include('dashboard.form.edit-components.date-time-input', [
            'label' => 'Дата публикации',
            'name' => 'publish_at',
            'required' => false,
        ])
    </form>

    @include('dashboard.modals.single-destroy', ['itemID' => $item->id])
@endsection
