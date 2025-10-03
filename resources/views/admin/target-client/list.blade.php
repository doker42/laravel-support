@extends('admin.dashboard')

@section('dashboard')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">{{__('TargetClients')}}</h1>

        <div class="btn-toolbar mb-2 mb-md-0">
{{--            <div class="btn-group me-2">--}}
{{--                <a href="{{route('target_create')}}" class="btn btn-sm btn-outline-primary">--}}
{{--                    {{__("Add target")}}--}}
{{--                </a>--}}
{{--            </div>--}}
        </div>
    </div>


    @php($num = 1)
    @if(count($targetClients))
        <div class="table-responsive small">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID</th>
                    <th scope="col">{{__('Url')}}</th>
                    <th scope="col">{{__('Client')}}</th>
                    <th scope="col">{{__('Interval')}}</th>
                    <th scope="col">{{__('Active')}}</th>
                    <th scope="col">{{__('Actions')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($targetClients as $targetClient)
                    <tr>
                        <td>{{$num}}</td>
                        <td>{{$targetClient->id}}</td>
                        <td>
                            <a class="btn-outline-secondary" href="{{ route('target_client_show', ['targetClient' => $targetClient]) }}">
                                {{$targetClient->target->url}}
                            </a>
                        </td>
                        <td>{{$targetClient->client->name}}</td>
                        <td>{{$targetClient->interval}}</td>
                        <td>
                            @php($active = (bool)$targetClient->active)
                            <button type="button"
                                    class="btn btn-toggle-active btn-outline-{{ $active ? 'success' : 'secondary' }} btn-sm"
                                    data-id="{{ $targetClient->id }}">
                                {{ $active ? 'ON' : 'OFF' }}
                            </button>
                        </td>
                        <td  style="display: flex; gap: 5px; align-items: center;">
                            <a class="btn-outline-secondary" href="{{ route('target_client_edit', ['targetClient' => $targetClient]) }}">
                                <button class="btn btn-outline-warning btn-sm">
                                    <svg class="bi"><use xlink:href="#edit"/></svg>
                                </button>
                            </a>
{{--                            <form action="{{ route('target_client_destroy', $targetClient) }}" method="POST" onsubmit="return confirmDelete(event)">--}}
{{--                                @csrf--}}
{{--                                @method('DELETE')--}}
{{--                                <button class="btn btn-outline-secondary btn-sm">--}}
{{--                                    <svg class="bi"><use xlink:href="#trash"/></svg>--}}
{{--                                </button>--}}
{{--                            </form>--}}
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

@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.btn-toggle-active').forEach(function (button) {
                button.addEventListener('click', function () {
                    const id = this.dataset.id;
                    const btn = this;

                    fetch(`/adm/target-client/toggle-active/${id}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                if (data.active) {
                                    btn.classList.remove('btn-outline-secondary');
                                    btn.classList.add('btn-outline-success');
                                    btn.textContent = 'ON';
                                } else {
                                    btn.classList.remove('btn-outline-success');
                                    btn.classList.add('btn-outline-secondary');
                                    btn.textContent = 'OFF';
                                }
                            }
                        })
                        .catch(err => console.error(err));
                });
            });
        });
    </script>

@endpush
