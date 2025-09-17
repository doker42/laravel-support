@extends('admin.dashboard')

@section('dashboard')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">{{__('Plan')}} {{$plan->title}}</h1>

        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{route('plan_list')}}" class="btn btn-sm btn-outline-primary">
                    {{__("List")}}
                </a>
            </div>
        </div>
    </div>

    @if($plan)
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
                        <td>Title</td><td>{{$plan->title}}</td>
                    </tr>
                    <tr>
                        <td>Desc</td><td>{{$plan->description}}</td>
                    </tr>
                    <tr>
                        <td>Price</td><td>{{$plan->price}}</td>
                    </tr>
                    <tr>
                        <td>Limit</td><td>{{$plan->limit}}</td>
                    </tr>
                    <tr>
                        <td>Period</td><td>{{$plan->period}}</td>
                    </tr>
                    <tr>
                        <td>Duration</td><td>{{$plan->duration}}</td>
                    </tr>
                    <tr>
                        <td>Active</td>
                        <td>
                            {{$plan->active ? 'Active' : "Inactive"}}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    @else
        <h2>{{__('No plan')}}</h2>
    @endif

@endsection
