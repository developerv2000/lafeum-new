<div class="folders-list">
    @foreach ($rootFolders as $folder)
        <div class="folders-list__item folders-list__item--root">
            <svg class="folders-list__svg">
                <use href="#folder-svg"></use>
            </svg>

            <a class="folders-list__link" href="{{ route('folders.show', $folder->id) }}">{{ $folder->name }}</a>
            <input class="folders-list__input" type="text" name="name" value="{{ $folder->name }}" form="editForm{{ $folder->id }}">

            <x-folder-forms :folder="$folder" />
        </div>

        @if ($folder->childs->count())
            <div class="folders-list__childs-container">
                @foreach ($folder->childs as $child)
                    <div class="folders-list__item folders-list__item--child">
                        <svg class="folders-list__svg">
                            <use href="#subfolder-svg"></use>
                        </svg>

                        <a class="folders-list__link" href="{{ route('folders.show', $child->id) }}">{{ $child->name }}</a>
                        <input class="folders-list__input" type="text" name="name" value="{{ $child->name }}" form="editForm{{ $child->id }}">

                        <x-folder-forms :folder="$child" />
                    </div>
                @endforeach
            </div>
        @endif
    @endforeach
</div>

{{-- Include modals --}}
@foreach ($rootFolders as $folder)
    @include('modals.delete-folder', ['folder' => $folder])

    @foreach ($folder->childs as $child)
        @include('modals.delete-folder', ['folder' => $child])
    @endforeach
@endforeach
