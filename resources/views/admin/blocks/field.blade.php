<div class="form-group field mb-3">
    <div class="row">
        {{----}}
        <div class="col-sm-2">
            <label>{{__('Field')}}</label>
        </div>
        <div class="col-sm-2">
            <label>{{__('Title')}}</label>
        </div>
        <div class="col-sm-4">
            <div class="mb-3">
                <input name="field[{{$num}}][title]" type="text" class="form-control" value="{{$field['title']}}">
            </div>
        </div>
        <div class="col-sm-4"></div>
        {{----}}
        <div class="col-sm-2"></div>
        <div class="col-sm-2">
            <label>{{__('Name')}}</label>
        </div>
        <div class="col-sm-4">
            <div class="mb-3">
                <input name="field[{{$num}}][name]" type="text" class="form-control" value="{{$field['name']}}">
            </div>
        </div>
        <div class="col-sm-4"></div>
        {{----}}
        <div class="col-sm-2"></div>
        <div class="col-sm-2">
            <label>{{__('Type')}}</label>
        </div>
        <div class="col-sm-4">
            <select name="field[{{$num}}][type]"  class="form-select" aria-label="{{__('FieldType')}}">
                @foreach($types as $type)
                    <option value="{{$type->id}}">{{__($type->title)}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-4"></div>
        {{----}}
        <div class="col-sm-2"></div>
        <div class="col-sm-2 mt-3 mb-3">
            <label>{{__('Required')}}</label>
        </div>
        <div class="col-sm-1">
            <div class="form-check mt-3 mb-3">
                <input name="field[{{$num}}][required]" class="form-check-input" type="checkbox" value="1" {{isset($field['required'])?'checked':''}}>
            </div>
        </div>
        <div class="col-sm-2 mt-3 mb-3">
            <label>{{__('Show in table')}}</label>
        </div>
        <div class="col-sm-2">
            <div class="form-check mt-3 mb-3">
                <input name="field[{{$num}}][show_in_table]" class="form-check-input" type="checkbox" value="1"  {{isset($field['show_in_table'])?'checked':''}}>
            </div>
        </div>
        <div class="col-sm-1">
            <div class="d-grid gap-1">
                <button type="button" onclick="rmField(this)" class="btn bth-sm btn-outline-secondary remove">Remove</button>
            </div>
        </div>
        <div class="col-sm-2"></div>

    </div>
</div>
