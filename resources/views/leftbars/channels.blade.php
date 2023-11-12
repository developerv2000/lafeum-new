<aside class="leftbar channels-leftbar leftbar--fixed-height">
    <div class="leftbar__inner">
        <h2 class="main-title leftbar__title">Все Каналы</h2>
        <x-search.local form-class="channels-leftbar__search" selector=".leftbar__collapse-link" />

        <div class="collapse leftbar__collapse channels-leftbar__collapse collapse--active">
            <button class="collapse__button"> Каналы
                <span class="collapse__button-icon material-symbols-outlined">chevron_right</span>
            </button>

            <div class="collapse__content thin-scrollbar">
                <div class="collapse__inner">
                    @foreach ($channels as $chan)
                        <a class="leftbar__collapse-link" href="{{ route('channels.show', $chan->slug) }}">{{ $chan->name }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</aside>
