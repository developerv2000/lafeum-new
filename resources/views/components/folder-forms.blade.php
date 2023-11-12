<div class="folder-forms">
    {{-- Upgrade --}}
    <form class="folders-upgrade" action="{{ route('folders.upgrade') }}" method="POST" data-on-submit="show-spinner">
        @csrf

        <input type="hidden" name="id" value="{{ $folder->id }}">
        <x-button style="transparent" icon="straight" title="Наверх"></x-button>
    </form>

    {{-- Downgrade --}}
    <form class="folders-downgrade" action="{{ route('folders.downgrade') }}" method="POST" data-on-submit="show-spinner">
        @csrf

        <input type="hidden" name="id" value="{{ $folder->id }}">
        <x-button style="transparent" icon="straight" title="Вниз"></x-button>
    </form>

    {{-- Edit --}}
    <form class="folders-edit" action="{{ route('folders.update') }}" method="POST" data-on-submit="show-spinner" id="editForm{{ $folder->id }}">
        @csrf

        <input type="hidden" name="id" value="{{ $folder->id }}">
        <x-button class="folders-edit__edit-btn" style="transparent" icon="edit_note" type="button" title="Переименовать"></x-button>
        <x-button class="folders-edit__save-btn" style="transparent" icon="download_done" title="Переименовать"></x-button>
    </form>

    {{-- Delete --}}
    <x-show-modal-button style="transparent" icon="delete" target="#deleteFolderModal{{ $folder->id }}" title="Удалить"></x-show-modal-button>
</div>
