<div class="form__group">
    <label class="form__label @if($required) required @endif">{{ $label }}</label>

    <select class="selectize-singular" name="{{ $name }}" @required($required) @unless($required) placeholder="Не выбрано" @endunless>
        @unless ($required)
            <option></option>
        @endunless

        @foreach ($options as $option)
            <option value="{{ $option->{$valueColumnName} }}">{{ $option->{$titleColumnName} }}</option>
        @endforeach
    </select>
</div>
