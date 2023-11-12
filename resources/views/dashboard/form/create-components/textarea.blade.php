<div class="form__group">
    <label class="form__label @if($required) required @endif">{{ $label }}</label>

    <textarea class="form__textarea" name="{{ $name }}" @required($required) rows="5">{{ old($name) }}</textarea>
</div>
