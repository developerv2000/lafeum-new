<div class="modal modal--single-restore">
    <div class="modal__overlay" data-action="hide-modal"></div>

    <div class="modal__inner">
        <div class="modal__box">
            <form class="modal__form" action="{{ route($modelPrefixName . '.restore') }}" method="POST" data-on-submit="show-spinner">
                @csrf
                <input type="hidden" name="id">

                <div class="modal__header">
                    <p class="modal__header-title">Восстановление</p>

                    <button class="modal__dismiss" type="button" data-action="hide-modal">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <div class="modal__body">
                    Вы уверены что хотите восстановить?
                </div>

                <div class="modal__footer">
                    <button class="button button--secondary" type="button" data-action="hide-modal">Отмена</button>
                    <button class="button button--success" type="submit">Восстановить</button>
                </div>
            </form>
        </div>
    </div>
</div>
