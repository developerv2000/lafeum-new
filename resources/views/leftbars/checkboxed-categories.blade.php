<aside class="leftbar checkboxed-leftbar">
    <div class="leftbar__inner">
        <h2 class="main-title leftbar__title">Фильтр</h2>
        <x-reset-link class="leftbar__action" href="{{ url()->current() }}" />

        <div class="leftbar__collapses-container">
            @foreach ($categories as $category)
                <div class="collapse leftbar__collapse checkboxed-leftbar__collapse collapse--active">
                    <button class="collapse__button"> {{ $category->name }}
                        <span class="collapse__button-icon material-symbols-outlined">chevron_right</span>
                    </button>

                    <div class="collapse__content">
                        <div class="collapse__inner">
                            {{-- Root Category --}}
                            <label class="label--checkboxed unselectable">
                                <input class="checkboxed-leftbar__checkbox" type="checkbox" name="cats[]" value="{{ $category->id }}" form="{{ $formID }}" @checked(in_array($category->id, $activeCategoryIDs)) />{{ $category->name }}
                            </label>

                            {{-- Child Categories --}}
                            @foreach ($category->children as $child)
                                <label class="label--checkboxed unselectable">
                                    <input class="checkboxed-leftbar__checkbox" type="checkbox" name="cats[]" value="{{ $child->id }}" form="{{ $formID }}" @checked(in_array($child->id, $activeCategoryIDs)) />{{ $child->name }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</aside>
