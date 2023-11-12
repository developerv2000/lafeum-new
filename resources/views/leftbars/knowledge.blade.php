<aside class="leftbar knowledge-leftbar">
    <div class="leftbar__inner">
        <h2 class="main-title leftbar__title">Область знаний</h2>
        <x-reset-link class="leftbar__action" href="{{ route('knowledge.index') }}" text="Все области знаний" />
        <x-search.local form-class="knowledge-leftbar__search" selector=".leftbar__collapse-link" />

        <div class="leftbar__collapses-container">
            @foreach ($knowledges as $item)
                <div class="collapse leftbar__collapse knowledge-leftbar__collapse @if ($loop->first) collapse--active @endif">
                    <button class="collapse__button"> {{ $item->name }}
                        <span class="collapse__button-icon material-symbols-outlined">chevron_right</span>
                    </button>

                    <div class="collapse__content">
                        <div class="collapse__inner">
                            @foreach ($item->children as $child)
                                <a class="leftbar__collapse-link" href="{{ route('knowledge.show', $child->slug) }}">{{ $child->name }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</aside>
