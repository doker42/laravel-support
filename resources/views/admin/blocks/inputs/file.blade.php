<div class="form-group">
    <label for="{{'item_'.$el['id']}}" class="form-label">{{$el['label']}}</label>
    <input
            class="form-control"
            name="file"
            type="file"
            id="{{'item_'.$el['id']}}"
            {{$disabled ? 'disabled' : ''}}
            {{$el['required'] ? 'required' : ''}}
    >
</div>