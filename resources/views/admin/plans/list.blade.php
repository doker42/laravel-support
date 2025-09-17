@extends('admin.dashboard')

@section('dashboard')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">{{__('Plans')}}</h1>

        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{route('plan_create')}}" class="btn btn-sm btn-outline-primary">
                    {{__("Add plan")}}
                </a>
            </div>
        </div>
    </div>


    @php($num = 1)
    @if(count($plans))
        <div class="table-responsive small">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID</th>
                    <th scope="col">{{__('Title')}}</th>
                    <th scope="col">{{__('Desc')}}</th>
                    <th scope="col">{{__('Price')}}</th>
                    <th scope="col">{{__('Limit')}}</th>
                    <th scope="col">{{__('Interval')}}</th>
                    <th scope="col">{{__('Duration')}}</th>
                    <th scope="col">{{__('Active')}}</th>
                    <th scope="col">{{__('Actions')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($plans as $plan)
                    <tr>
                        <td>{{$num}}</td>
                        <td>{{$plan->id}}</td>
                        <td>
                            <a class="btn-outline-secondary" href="{{ route('plan_show', ['plan' => $plan]) }}">
                                {{$plan->title}}
                            </a>
                        </td>
                        <td>{{$plan->description}}</td>
                        <td>{{$plan->price}}</td>
                        <td>{{$plan->limit}}</td>
                        <td>{{$plan->interval}}</td>
                        <td>{{$plan->duration}}</td>
                        <td>
                            @php($active = (bool)$plan->active)
                            <button class="btn btn-outline-{{$active ? 'success' : 'secondary'}} btn-sm">
                                {{$active ? 'ON' : 'OFF'}}
                            </button>
                        </td>
                        <td  style="display: flex; gap: 5px; align-items: center;">
                            <div class="d-flex gap-1">
                                <a class="btn-outline-secondary" href="{{ route('plan_edit', ['plan' => $plan]) }}">
                                    <button class="btn btn-outline-warning btn-sm">
                                        <svg class="bi"><use xlink:href="#edit"/></svg>
                                    </button>
                                </a>
                                <form action="{{ route('plan_destroy', $plan) }}" method="POST" onsubmit="return confirmDelete(event)">
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
