@extends('admin.admin_basic')

@section('dashboard')
    <h3>Admin Dashboard</h3>

    <form action="{{ route('bot.toggle') }}" method="POST">
        @csrf
        @if(session('bot_enabled'))
            <button type="submit" class="btn btn-danger">🚫 Выключить бота</button>
        @else
            <button type="submit" class="btn btn-success">✅ Включить бота</button>
        @endif
    </form>

@endsection

