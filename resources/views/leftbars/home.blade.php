<aside class="leftbar home-leftbar">
    <div class="leftbar__inner">
        <h2 class="main-title leftbar__title">Темы</h2>

        <div class="leftbar__collapses-container">
            @foreach ($categories as $category)
                {{-- Collapses --}}
                <div class="collapse collapse--active leftbar__collapse home-leftbar__collapse">
                    <button class="collapse__button">{{ $category->name }}
                        <span class="collapse__button-icon material-symbols-outlined">chevron_right</span>
                    </button>

                    <div class="collapse__content">
                        {{-- Accordions --}}
                        <div class="accordion">
                            {{-- Root Category --}}
                            <div class="accordion__item">
                                <button class="accordion__button"> {{ $category->name }}
                                    <span class="accordion__button-icon material-symbols-outlined">chevron_right</span>
                                </button>

                                <div class="accordion__collapse">
                                    <ul class="accordion__collapse__inner">
                                        @foreach ($category->supportedTypeLinks as $link)
                                            <li><a href="{{ $link['href'] }}">{{ $link['label'] }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            {{-- Child categories --}}
                            @foreach ($category->children as $child)
                                <div class="accordion__item">
                                    <button class="accordion__button"> {{ $child->name }}
                                        <span class="accordion__button-icon material-symbols-outlined">chevron_right</span>
                                    </button>

                                    <div class="accordion__collapse">
                                        <ul class="accordion__collapse__inner">
                                            @foreach ($child->supportedTypeLinks as $link)
                                                <li><a href="{{ $link['href'] }}">{{ $link['label'] }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div> {{-- Accordion --}}
                    </div> {{-- Collapse Content --}}
                </div> {{-- Collapse --}}
            @endforeach
        </div> {{-- Collapses Container --}}
    </div>
</aside>
