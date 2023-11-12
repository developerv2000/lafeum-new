<aside class="leftbar authors-leftbar leftbar--fixed-height">
    <div class="leftbar__inner">
        <h2 class="main-title leftbar__title">Все Авторы</h2>
        <x-search.local form-class="authors-leftbar__search" selector=".leftbar__collapse-link" />

        <div class="collapse leftbar__collapse authors-leftbar__collapse collapse--active">
            <button class="collapse__button"> Авторы
                <span class="collapse__button-icon material-symbols-outlined">chevron_right</span>
            </button>

            <div class="collapse__content thin-scrollbar">
                <div class="collapse__inner">
                    @foreach ($authors as $auth)
                        <a class="leftbar__collapse-link" href="{{ route('authors.show', $auth->slug) }}">{{ $auth->name }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</aside>
