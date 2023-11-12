<div class="form__group">
    <label class="form__label @if($required) required @endif">{{ $label }}</label>

    <textarea class="wysiwyg-textarea" name="{{ $name }}" @required($required)>{{ old($name, $item->{$name}) }}</textarea>
</div>
