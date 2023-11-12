@props(['inputName'])

<div class="form-group @error($inputName) form-group--error @enderror">
    <label class="label">@error($inputName) {{ $message }} @enderror</label>
    {{ $slot }}
    <span class="material-symbols-outlined form-group__icon form-group__icon--error">close</span>
    <span class="material-symbols-outlined form-group__icon form-group__icon--valid">done</span>
</div>
