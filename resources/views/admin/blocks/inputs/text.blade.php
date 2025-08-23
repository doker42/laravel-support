<div class="form-group">
    <label>{{__($el['label'])}}</label>
    <input
            name="{{$el['name']}}"
            type="text"
            class="form-control"
            value="{{$el['value']}}"
            {{$disabled ? 'disabled' : ''}}
            {{$el['required'] ? 'required' : ''}}
    >
</div>