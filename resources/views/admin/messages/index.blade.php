@extends('layouts.admin')
@section('content')
    <h4 class="d-flex justify-content-between align-items-center mt-3">
        <span class="text-primary">Сообщения</span>
        @if(session('info'))
            <span class="badge bg-primary rounded-pill">{{ session('info') }}</span>
        @endif
    </h4>
    <ul class="list-group mb-3">
        @foreach($messages as $message)
            <li class="list-group-item d-flex justify-content-between lh-sm">
                <div>
                    <h6 class="my-0">{{$message->message}}</h6>
                    @if(session('success') && session('success') === $message->id)
                        <span class="badge bg-primary rounded-pill">new</span>
                    @endif
                    @if($message->user_id)
                        <small class="text-muted">{{$message->user->name}}</small>
                    @endif
                </div>
                <a href="{{route('messages.show', $message->id)}}">
                    <button class="btn btn-success btn-sm">Изменить</button>
                </a>

                <form action="{{route('messages.destroy', $message->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Удалить</button>
                </form>

                <span class="text-muted">100₽</span>
            </li>
        @endforeach
            <li class="list-group-item list-group-item-action  lh-sm" aria-current="true">
                {{ $messages->withQueryString()->links() }}
            </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>Total (РУБ)</span>
            <strong>130</strong>
        </li>
    </ul>
@endsection
