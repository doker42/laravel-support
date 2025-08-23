<label>{{__($el['label'])}}</label>
<select
        name="{{$el['name']}}"
        class="form-select"
        aria-label="{{__($el['label'])}}"
        {{$disabled ? 'disabled' : ''}}
        {{$el['required'] ? 'required' : ''}}
>
    <option value="{{$el['name']}}">{{__($el['label'])}}</option> {{-- TODO --}}
{{--    @foreach($list as $el)--}}
{{--        <option value="{{$el->id}}">{{__($el->title)}}</option>--}}
{{--    @endforeach--}}
</select>