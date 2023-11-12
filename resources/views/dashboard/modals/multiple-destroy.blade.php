<div class="modal modal--multiple-destroy">
    <div class="modal__overlay" data-action="hide-modal"></div>

    <div class="modal__inner">
        <div class="modal__box">
            <form class="modal__form" id="multiple-destroy-form" action="{{ route($modelPrefixName . '.destroy') }}" method="POST" data-on-submit="show-spinner">
                @csrf

                @if (strpos($routeName, '.dashboard.trash'))
                    <input type="hidden" name="permanently" value="1">
                @endif

                <div class="modal__header">
                    <p class="modal__header-title">Удалить</p>

                    <button class="modal__dismiss" type="button" data-action="hide-modal">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <div class="modal__body">
                    Вы уверены что хотите удалить отмеченные
                    @if (strpos($routeName, '.dashboard.trash'))
                        <strong>безвозвратно</strong>
                    @endif
                    ?
                </div>

                <div class="modal__footer">
                    <button class="button button--secondary" type="button" data-action="hide-modal">Отмена</button>
                    <button class="button button--danger" type="submit">Удалить</button>
                </div>
            </form>
        </div>
    </div>
</div>
