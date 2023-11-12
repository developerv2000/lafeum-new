<div class="nested-container">
    <ol class="nested">
        @foreach ($items as $item)
            <li class="nested__item" id="menuItem_{{ $item->id }}">
                <div class="nested__item-body">
                    <span class="nested__item-toggler material-symbols-outlined">expand_less</span>
                    <span class="nested__item-title">{{ $item->name }}</span>
                    <span class="nested__item-destroy-btn material-symbols-outlined">close</span>
                </div>

                @if (count($item->children))
                    <ol>
                        @foreach ($item->children as $child)
                            <li class="nested__item" id="menuItem_{{ $child->id }}">
                                <div class="nested__item-body">
                                    <span class="nested__item-toggler material-symbols-outlined">expand_less</span>
                                    <span class="nested__item-title">{{ $child->name }}</span>
                                    <span class="nested__item-destroy-btn material-symbols-outlined">close</span>
                                </div>
                            </li>
                        @endforeach
                    </ol>
                @endif
            </li>
        @endforeach
    </ol>
</div>
