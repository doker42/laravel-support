@extends('admin.dashboard')

@section('dashboard')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="h4 content-title">{{__('Plans')}}</h4>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{route('plan_list')}}" class="btn btn-sm btn-outline-primary">
                    {{__("List")}}
                </a>
            </div>
        </div>
    </div>

    <!-- right column -->
    <div class="col-md-12">
        <!-- general form elements disabled -->
        <div class="card card-primary">
            <div class="card-header">
                <h5 class="card-title content-title">{{__('Plan edit')}}</h5>
            </div>

            <div class="card-body">

                <form role="form" action="{{ route('plan_update', $plan) }}" method="post">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="row">
                            {{-- title --}}
                            <div class="col-sm-6 mb-3">
                                <div class="form-group">
                                    <label>{{__('Title')}}</label>
                                    <input name="title" type="text" class="form-control" value="{{$plan->title}}" required>
                                </div>
                            </div>
                            {{-- DESCRIPTION --}}
                            <div class="col-sm-6 mb-3">
                                <div class="form-group">
                                    <label>{{__('Description')}}</label>
{{--                                    <input name="description" type="text" class="form-control" value="{{$plan->description}}" required>--}}
                                    <textarea name="description" type="text" class="form-control" required>{{$plan->description}}</textarea>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Price --}}
                            <div class="col-sm-3 mb-3">
                                <div class="form-group">
                                    <label>{{__('Price')}}</label>
                                    <input name="price" type="number" class="form-control" value="{{$plan->price}}" required>
                                </div>
                            </div>
                            {{-- Limit --}}
                            <div class="col-sm-3 mb-3">
                                <div class="form-group">
                                    <label>{{__('Limit')}}</label>
                                    <input name="limit" type="number" class="form-control" value="{{$plan->limit}}" required>
                                </div>
                            </div>
                            {{-- INTERVAL --}}
{{--                            <div class="col-sm-3 mb-3">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label>{{__('Interval')}}</label>--}}
{{--                                    <input name="interval" type="number" class="form-control" value="{{$plan->interval}}" required>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            {{-- PLAN --}}
                            <div class="col-sm-6 mb-3">
                                <div class="form-group">
                                    <label>{{__('Intervals')}}</label>
                                    <select class="form-select" name="intervals" id="intervals" >
{{--                                        <option value="{{$client->plan->id}}" selected>{{$client->plan->title}}</option>--}}
                                        @foreach($intervals as $key => $val)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- Duration --}}
                            <div class="col-sm-3 mb-3">
                                <div class="form-group">
                                    <label>{{__('Duration')}}</label>
                                    <input name="duration" type="number" class="form-control" value="{{$plan->duration}}" required>
                                </div>
                            </div>
                        </div>

                        {{-- ACTIVE --}}
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>{{__('Active')}}</label>
                                <div class="form-check form-switch mt-2">
                                    <input id="active" name="active"
                                           class="form-check-input"
                                           type="checkbox" role="switch"
                                           {{$plan->active ? 'checked' : ''}}
                                    >
                                    <label class="form-check-label" for="active">{{__('Active status')}}</label>
                                </div>
                            </div>
                        </div>

                       {{-- DEFAULT --}}
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>{{__('Default')}}</label>
                                <div class="form-check form-switch mt-2">
                                    <input id="default" name="default"
                                           class="form-check-input"
                                           type="checkbox" role="switch"
                                            {{$plan->default ? 'checked' : ''}}
                                    >
                                    <label class="form-check-label" for="default">{{__('Default plan')}}</label>
                                </div>
                            </div>
                        </div>

                        {{-- REGULAR --}}
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>{{__('Regular')}}</label>
                                <div class="form-check form-switch mt-2">
                                    <input id="regular" name="regular"
                                           class="form-check-input"
                                           type="checkbox" role="switch"
                                            {{$plan->default ? 'checked' : ''}}
                                    >
                                    <label class="form-check-label" for="regular">{{__('Regular plan')}}</label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <button type="submit" class="btn btn-sm btn-outline-primary mt-3">{{__('UPDATE')}}</button>
                </form>
            </div>
        </div>
    </div>



@endsection