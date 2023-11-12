<header class="header">
    {{-- Toggler --}}
    <div class="header__toggler-container">
        <h2 class="header__site-name">{{ env('APP_NAME') }}</h2>
        <button class="aside-toggler"><span class="material-symbols-outlined">menu</span></button>
    </div>

    {{-- Body start --}}
    <div class=" header__body">
        {{-- Breadcrumbs --}}
        <ul class="header__breadcrumbs">
            @foreach ($breadcrumbs as $crumb)
                <li>{!! $crumb !!}</li>
            @endforeach
        </ul>

        {{-- Actions --}}
        <div class="header__actions">
            @if (in_array('create', $actions))
                <a href="{{ route($modelPrefixName . '.create') }}">
                    <span class="material-symbols-outlined">add</span> Добавить
                </a>
            @endif

            @if (in_array('store', $actions))
                <button type="submit" form="create-form">
                    <span class="material-symbols-outlined">add</span> Сохранить
                </button>
            @endif

            @if (in_array('update', $actions))
                <button type="submit" form="edit-form">
                    <span class="material-symbols-outlined">done_all</span> Обновить
                </button>
            @endif

            @if (in_array('destroy', $actions))
                <button data-action="show-modal" data-modal-target=".modal--single-destroy">
                    <span class="material-symbols-outlined">done_all</span> Удалить
                </button>
            @endif

            @if (in_array('edit-nestedset', $actions))
                <a href="{{ route($modelPrefixName . '.edit-nestedset') }}">
                    <span class="material-symbols-outlined">sort</span> Изменить структуру
                </a>
            @endif

            @if (in_array('multiselect', $actions))
                <button class="header__action-select-all">
                    <span class="material-symbols-outlined">done_all</span> Отметить все
                </button>
            @endif

            @if (in_array('multiple-destroy', $actions))
                <button data-action="show-modal" data-modal-target=".modal--multiple-destroy">
                    <span class="material-symbols-outlined">clear</span> Удалить отмеченные
                </button>
            @endif

            @if (in_array('update-nestedset', $actions))
                <button data-action="update-nestedset" data-url="{{ $updateNestedsetUrl }}">
                    <span class="material-symbols-outlined">done_all</span> Обновить
                </button>
            @endif

            {{-- While Model requested --}}
            @if (in_array('create-for-model', $actions))
                <a href="{{ route($modelPrefixName . '.create') }}?model={{ request()->model }}">
                    <span class="material-symbols-outlined">add</span> Добавить
                </a>
            @endif

            @if (in_array('edit-nestedset-of-model', $actions))
                <a href="{{ route($modelPrefixName . '.edit-nestedset') }}?model={{ request()->model }}">
                    <span class="material-symbols-outlined">sort</span> Изменить структуру
                </a>
            @endif

            @if (in_array('update-nestedset-of-model', $actions))
                <button data-action="update-nestedset" data-url="{{ $updateNestedsetUrl }}" data-model="{{ request()->model }}">
                    <span class="material-symbols-outlined">done_all</span> Обновить
                </button>
            @endif
        </div>
    </div> {{-- Body end --}}
</header>
