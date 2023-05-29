@extends('layouts.main')
@section('content')
    <h4 class="d-flex justify-content-between align-items-center mb-3">
        <span class="text-primary">Текущие расходы - {{ $message->id }}</span>
        @if(session('info'))
            <span class="badge bg-primary rounded-pill">{{ session('info') }}</span>
        @endif
    </h4>
    <ul class="list-group mb-3">
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
                <span class="text-muted">100₽</span>
            </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>Total (РУБ)</span>
            <strong>130</strong>
        </li>
    </ul>
    @if($errors->any())

        <ul class="list-group list-group-flush list-unstyled text-center">
            @foreach($errors->all() as $error)
                <li class="list-group-item list-group-item-danger">{{$error}}</li>
            @endforeach
        </ul>

    @endif
    <form class="card p-2" action="{{ route('messages.update', $message->id) }}" method="post">
        @csrf
        @method('patch')
        <div class="input-group">
             <textarea class="form-control form-control-lg" placeholder="Leave a comment here" name="message"
                       id="message">{{ $message->message }}</textarea>
            <button type="submit" class="btn btn-secondary">Изменить</button>
        </div>
    </form>

@endsection
