@extends('admin.dashboard')

@section('dashboard')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">{{__('TargetClient')}} {{$targetClient->target->url}}</h1>

        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{route('target_list')}}" class="btn btn-sm btn-outline-primary">
                    {{__("List")}}
                </a>
            </div>
        </div>
    </div>

    @php($num = 1)
    @if(count($statuses))
        <div class="table-responsive small">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{__('Down date')}}</th>
                    <th scope="col">{{__('Up date')}}</th>
                    <th scope="col">{{__('Down time (H:i)')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($statuses as $status)
                    <tr>
                        <td>{{$num}}</td>
                        <td>{{ $status['stop'] ? $status['stop']->format('Y-m-d H:i') : '-' }}</td>
                        <td>{{ $status['start'] ? $status['start']->format('Y-m-d H:i') : '-' }}</td>
                        <td>{{ $status['downtime'] }}</td>
                    </tr>
                    @php($num++)
                @endforeach
                </tbody>
            </table>
        </div>

    @else
        <h2>{{__('No info')}}</h2>
    @endif

@endsection
