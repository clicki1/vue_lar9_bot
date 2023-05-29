@extends('layouts.main')
@section('content')
    <h4 class="d-flex justify-content-between align-items-center mt-3">
        @if(session('info'))
            <span class="badge bg-primary rounded-pill">{{ session('info') }}</span>
        @endif
    </h4>
    <form action="{{route('tags.index')}}" method="get">
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="title" placeholder="Поиск" aria-label="title" autocomplete="off">
            <select class="form-select" aria-label="Default select example" name="category_id">
                <option selected value="">Выберите категорию</option>
                @foreach($categories as $category)
                <option value="{{$category->id}}">{{$category->title}}</option>
                @endforeach
            </select>
            <a href="{{route('tags.index')}}" class="btn btn-outline-secondary" id="button22">Сбросить</a>
            <button class="btn btn-outline-dark" type="submit" id="button2">Поиск</button>
        </div>
    </form>
    @if($errors->any())

        <ul class="list-group list-group-flush list-unstyled text-center">
            @foreach($errors->all() as $error)
                <li class="list-group-item list-group-item-danger">{{$error}}</li>
            @endforeach
        </ul>
    @endif
@include('tags.widgets.lenta')
@include('tags.widgets.addbtn')
@endsection
