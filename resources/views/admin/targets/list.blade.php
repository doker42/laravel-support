@extends('admin.dashboard')

@section('dashboard')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">{{__('Targets')}}</h1>

        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{route('target_create')}}" class="btn btn-sm btn-outline-primary">
                    {{__("Add target")}}
                </a>
            </div>
        </div>
    </div>


    @php($num = 1)
    @if(count($targets))
        <div class="table-responsive small">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID</th>
                    <th scope="col">{{__('Url')}}</th>
                    <th scope="col">{{__('Period')}}</th>
                    <th scope="col">{{__('Active')}}</th>
                    <th scope="col">{{__('Actions')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($targets as $target)
                    <tr>
                        <td>{{$num}}</td>
                        <td>{{$target->id}}</td>
                        <td>
                            <a class="btn-outline-secondary" href="{{ route('target_show', ['target' => $target]) }}">
                                {{$target->url}}
                            </a>
                        </td>
                        <td>{{$target->period}}</td>
                        <td>
                            @php($active = (bool)$target->active)
                            <button class="btn btn-outline-{{$active ? 'success' : 'secondary'}} btn-sm">
                                {{$active ? 'ON' : 'OFF'}}
                            </button>
                        </td>
                        <td>
                            <a class="btn-outline-secondary" href="{{ route('target_edit', ['target' => $target]) }}">
                                <button class="btn btn-outline-warning btn-sm">
                                    <svg class="bi"><use xlink:href="#edit"/></svg>
                                </button>
                            </a>
                            <form action="{{ route('target_destroy', $target) }}" method="POST" onsubmit="return confirmDelete(event)">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-secondary btn-sm">
                                    <svg class="bi"><use xlink:href="#trash"/></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @php($num++)
                @endforeach
                </tbody>
            </table>
        </div>

    @else
        <h2>{{__('No targets')}}</h2>
    @endif

@endsection
