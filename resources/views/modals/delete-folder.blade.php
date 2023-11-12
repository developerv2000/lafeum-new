<div class="modal delete-folder-modal" id="deleteFolderModal{{ $folder->id }}">
    <div class="modal__background"></div>
    <div class="modal__box">
        <div class="modal__header">
            <h6 class="main-title modal__title">Удаление</h6>
            <p class="modal__desc">Вы уверены, что хотите удалить данный раздел? <br><br>Данное действие не обратимо</p>
        </div>

        <div class="modal__body">
            <form class="form delete-folder-form" action="{{ route('folders.remove') }}" method="POST" data-on-submit="show-spinner">
                @csrf
                <input type="hidden" name="id" value="{{ $folder->id }}">

                <div class="modal__buttons-row">
                    <x-button class="login-form__submit" style="danger" icon="delete">
                        Удалить
                    </x-button>

                    <x-hide-modal-button class="login-form__submit" style="dark" icon="close">
                        Отменить
                    </x-hide-modal-button>
                </div>
            </form>
        </div>
    </div>
</div>
