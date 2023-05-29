@extends('layouts.main')
@section('content')
    <h4 class="d-flex justify-content-between align-items-center mt-3">
        <span class="text-primary">Текущие расходы</span>
        @if(session('info'))
            <span class="badge bg-primary rounded-pill">{{ session('info') }}</span>
        @endif
    </h4>
    <form action="{{route('messages.index')}}" method="get">
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="message" placeholder="Поиск" aria-label="message" autocomplete="off">
            <a href="{{route('messages.index')}}" class="btn btn-outline-secondary" id="button22">Сбросить</a>
            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Поиск</button>
        </div>
    </form>
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

                <span class="text-muted">{{ $message->created_at }}</span>
                <span class="badge bg-primary">
                    @foreach($message->results  as $res)
                        <p>{{ $res->coast }}</p>
                    @endforeach


                </span>
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
    @include('widget.create')
@endsection
