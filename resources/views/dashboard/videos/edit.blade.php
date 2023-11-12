@extends('dashboard.layouts.app', [
    'breadcrumbs' => ['Видео', 'Редактировать', '#' . $item->id],

    'actions' => ['update', 'destroy'],
])

@section('main')
    <form class="form" id="edit-form" action="{{ route($modelPrefixName . '.update') }}" method="POST">
        @csrf
        @include('dashboard.form.edit-components.id-input')
        @include('dashboard.form.edit-components.previous-url-input')

        @include('dashboard.form.edit-components.text-input', [
            'label' => 'Заголовок',
            'name' => 'title',
            'required' => true,
        ])

        @include('dashboard.form.edit-components.text-input', [
            'label' => 'Ссылка',
            'name' => 'host_id',
            'required' => true,
        ])

        {{-- Template not used because name & value differ --}}
        <div class="form__group">
            <label class="form__label required">Ссылка</label>

            <input class="form__input" type="text" name="host_id" required value="{{ old('host_id', $item->link) }}">
        </div>

        @include('dashboard.form.edit-components.single-select', [
            'label' => 'Канал',
            'name' => 'channel_id',
            'required' => true,
            'options' => $channels,
            'relationName' => 'channel',
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

        @include('dashboard.form.edit-components.date-time-input', [
            'label' => 'Дата публикации',
            'name' => 'publish_at',
            'required' => true,
        ])
    </form>

    @include('dashboard.modals.single-destroy', ['itemID' => $item->id])
@endsection
