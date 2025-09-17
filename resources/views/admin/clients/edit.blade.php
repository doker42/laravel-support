@extends('admin.dashboard')

@section('dashboard')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="h4 content-title">{{__('Clients')}}</h4>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{route('target_list')}}" class="btn btn-sm btn-outline-primary">
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
                <h5 class="card-title content-title">{{__('Target edit')}}</h5>
            </div>

            <div class="card-body">

                <form role="form" action="{{ route('client_update', $client) }}" method="post">
                    @csrf
                    @method('POST')
                    <div class="row">
                        {{-- NAME --}}
                        <div class="col-sm-12 mb-3">
                            <div class="form-group">
                                <label>{{__('Client')}}</label>
                                <input type="text" class="form-control" value="{{$client->name}}" disabled>
                            </div>
                        </div>
                        {{-- PLAN --}}
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                <label>{{__('Plans')}}</label>
                                <select class="form-select" name="plan_id" id="plan_id" >
                                    <option value="{{$client->plan->id}}" selected>{{$client->plan->title}}</option>
                                    @foreach($plans as $plan)
                                        <option value="{{$plan->id}}">{{$plan->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- ACTIVE --}}
{{--                        <div class="col-sm-6">--}}
{{--                            <div class="form-group">--}}
{{--                                <label>{{__('Active')}}</label>--}}
{{--                                <div class="form-check form-switch mt-2">--}}
{{--                                    <input id="active" name="active"--}}
{{--                                           class="form-check-input"--}}
{{--                                           type="checkbox" role="switch"--}}
{{--                                           {{$target->active ? 'checked' : ''}}--}}
{{--                                    >--}}
{{--                                    <label class="form-check-label" for="active">{{__('Active status')}}</label>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>

                    <button type="submit" class="btn btn-sm btn-outline-primary mt-3">{{__('UPDATE')}}</button>
                </form>
            </div>
        </div>
    </div>



@endsection