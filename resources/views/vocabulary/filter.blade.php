<section class="vocabulary-filter">
    {{-- First Level Collapse --}}
    <div class="collapse">
        <button class="collapse__button">Фильтр
            <span class="collapse__button-icon material-symbols-outlined">chevron_right</span>
        </button>

        <div class="collapse__content">
            <div class="collapse__content-inner">
                <x-reset-link class="vocabulary__filter-reset" />

                <div class="vocabulary-filter__nested-collapses">
                    @foreach ($categories as $category)
                        {{-- Second Level Collapses --}}
                        <div class="collapse collapse--active">
                            <button class="collapse__button">{{ $category->name }}
                                <span class="collapse__button-icon material-symbols-outlined">chevron_right</span>
                            </button>

                            <div class="collapse__content">
                                {{-- Root Category --}}
                                <label class="label--checkboxed unselectable">
                                    <input class="vocabulary__filter-checkbox" type="checkbox" name="cats[]" value="{{ $category->id }}" form="vocabulary-index-search" />{{ $category->name }}
                                </label>

                                {{-- Child Categories --}}
                                @foreach ($category->children as $child)
                                    <label class="label--checkboxed unselectable">
                                        <input class="vocabulary__filter-checkbox" type="checkbox" name="cats[]" value="{{ $child->id }}" form="vocabulary-index-search" />{{ $child->name }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
