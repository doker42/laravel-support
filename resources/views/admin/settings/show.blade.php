@extends('admin.dashboard')

@section('dashboard')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">{{__('Setting')}} {{$setting->key}}</h1>

        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{route('setting_list')}}" class="btn btn-sm btn-outline-primary">
                    {{__("List")}}
                </a>
            </div>
        </div>
    </div>

    @if($setting)
        <div class="table-responsive small">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">#</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Title</td><td>{{$setting->key}}</td>
                    </tr>
                    <tr>
                        <td>Desc</td><td>{{$setting->value}}</td>
                    </tr>
                </tbody>
            </table>
        </div>

    @else
        <h2>{{__('No setting')}}</h2>
    @endif

@endsection
