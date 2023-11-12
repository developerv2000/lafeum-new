<div class="form__group">
    <label class="form__label @if($required) required @endif">{{ $label }}</label>

    <select class="selectize-multiple" name="{{ $name }}" multiple @required($required)>
        @foreach ($options as $option)
            <option value="{{ $option->{$valueColumnName} }}">{{ $option->{$titleColumnName} }}</option>
        @endforeach
    </select>
</div>
