@extends('admin.dashboard')

@section('dashboard')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">{{__('Settings')}}</h1>

        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{route('setting_create')}}" class="btn btn-sm btn-outline-primary">
                    {{__("Add setting")}}
                </a>
            </div>
        </div>
    </div>


    @php($num = 1)
    @if(count($settings))
        <div class="table-responsive small">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID</th>
                    <th scope="col">{{__('Key')}}</th>
                    <th scope="col">{{__('value')}}</th>
                    <th scope="col">{{__('Actions')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($settings as $setting)
                    <tr>
                        <td>{{$num}}</td>
                        <td>{{$setting->id}}</td>
                        <td>
                            <a class="btn-outline-secondary" href="{{ route('setting_show', ['setting' => $setting]) }}">
                                {{$setting->key}}
                            </a>
                        </td>
                        <td>{{$setting->value}}</td>
                        <td  style="display: flex; gap: 5px; align-items: center;">
                            <div class="d-flex gap-1">
                                <a class="btn-outline-secondary" href="{{ route('setting_edit', ['setting' => $setting]) }}">
                                    <button class="btn btn-outline-warning btn-sm">
                                        <svg class="bi"><use xlink:href="#edit"/></svg>
                                    </button>
                                </a>
                                <form action="{{ route('setting_destroy', $setting) }}" method="POST" onsubmit="return confirmDelete(event)">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-secondary btn-sm">
                                        <svg class="bi"><use xlink:href="#trash"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @php($num++)
                @endforeach
                </tbody>
            </table>
        </div>

    @else
        <h2>{{__('No plans')}}</h2>
    @endif

@endsection
