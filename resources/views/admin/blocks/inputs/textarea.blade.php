<div class="form-group">
    <label>{{__($el['label'])}}</label>
    @php( $rows = isset($rows) ? $rows : 3)
    <textarea
            name="{{$el['name']}}"
            class="form-control"
            id="{{$el['id']}}"
            rows="{{$rows}}"
            {{$disabled ? 'disabled' : ''}}
            {{$el['required'] ? 'required' : ''}}
    >{{$el['value']}}</textarea>
</div>