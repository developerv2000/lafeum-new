<div class="dropdown favorite-dropdown">
    <button class="dropdown__button">
        <span class="material-symbols-outlined favorite-icon {{ $item->favoritedBy($currentUser->id) ? 'favorite-icon--active' : '' }}">bookmark</span>
    </button>

    <div class="dropdown__content">
        <div class="favorite-form">
            <p class="favorite-form__title">Выберите папку:</p>

            @foreach ($currentUser->rootFolders as $folder)
                <div class="favorite-form__item">
                    <label class="label"><input type="checkbox" value="{{ $folder->id }}" @checked($item->favoritedBy($currentUser->id, $folder->id))>{{ $folder->name }}</label>

                    @if ($folder->childs()->count())
                        <div class="favorite-form__childs">
                            <p class="favorite-form__title">Подпапки:</p>
                            @foreach ($folder->childs as $child)
                                <label class="label"><input type="checkbox" value="{{ $child->id }}" @checked($item->favoritedBy($currentUser->id, $child->id))>{{ $child->name }}</label>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach

            <button class="button button--dark" data-action="favorite" data-model="{{ $model }}" data-id="{{ $item->id }}">Сохранить</button>
        </div>
    </div>
</div>
