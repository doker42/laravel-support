@extends('admin.dashboard')

@section('dashboard')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">{{__('Clients')}}</h1>
    </div>


    @php($num = 1)
    @if(count($clients))
        <div class="table-responsive small">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID</th>
                    <th scope="col">CHAT_ID</th>
                    <th scope="col">AWAIT</th>
                    <th scope="col">{{__('Name')}}</th>
                    <th scope="col">{{__('Plan')}}</th>
                    <th scope="col">{{__('End Subscription')}}</th>
                    <th scope="col">{{__('Actions')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($clients as $client)
                    <tr>
                        <td>{{$num}}</td>
                        <td>{{$client->id}}</td>
                        <td>{{$client->chat_id}}</td>
                        <td>{{$client->await}}</td>
                        <td>{{$client->name}}</td>
                        <td>{{$client->plan->title}}</td>
                        <td>{{$client->end_subscription}}</td>
                        <td  style="display: flex; gap: 5px; align-items: center;">
                            <div class="d-flex gap-1">
                                <a class="btn-outline-secondary" href="{{ route('client_edit', ['client' => $client]) }}">
                                    <button class="btn btn-outline-warning btn-sm">
                                        <svg class="bi"><use xlink:href="#edit"/></svg>
                                    </button>
                                </a>
                                <form action="{{ route('client_destroy', $client) }}" method="POST" onsubmit="return confirmDelete(event)">
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
        <h2>{{__('No clients')}}</h2>
    @endif

@endsection
