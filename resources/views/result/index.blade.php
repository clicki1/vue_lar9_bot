@extends('layouts.main')
@section('content')
    <h4 class="d-flex justify-content-between align-items-center mt-3">
        @if(session('info'))
            <span class="badge bg-primary rounded-pill">{{ session('info') }}</span>
        @endif
    </h4>

    @if($errors->any())

        <ul class="list-group list-group-flush list-unstyled text-center">
            @foreach($errors->all() as $error)
                <li class="list-group-item list-group-item-danger">{{$error}}</li>
            @endforeach
        </ul>
    @endif
    <form action="{{route('results.index')}}" method="get">
        <div class="input-group mb-3">

            <select class="form-select" aria-label="Default select example" name="category_id">
                <option selected value="">Выберите категорию</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                    @if(isset($data['category_id']) && $data['category_id'] !== null)
                        {{ $category->id == $data['category_id'] ? 'selected' : '' }}

                        @endif
                    >{{ $category->title }}</option>
                @endforeach
            </select>
            <select class="form-select" aria-label="Default select example" name="year_res">
                <option selected value="">Год</option>
                @foreach($years as $year)
                    <option value="{{$year}}"
                    @if(isset($data['year_res']) && $data['year_res'] !== null)
                        {{ $year == $data['year_res'] ? 'selected' : '' }}
                        @endif
                    >{{$year}}</option>

                @endforeach
            </select>
            <select class="form-select" aria-label="Default select example" name="month_res">
                <option selected value="">Месяц</option>
                @foreach($months as $k => $month)
                    <option value="{{$k}}"
                    @if(isset($data['month_res']) && $data['month_res'] !== null)
                        {{ $k == $data['month_res'] ? 'selected' : '' }}
                        @endif
                    >{{$month}}</option>
                @endforeach
            </select>
            <a href="{{route('results.index', ['err_cat' => true])}}" class="btn btn-outline-danger
             @if(isset($data['err_cat']) && $data['err_cat'] !== null)
                        {{ "active" }}
             @endif
             " id="button33">Без категории</a>
            <a href="{{route('results.index')}}" class="btn btn-outline-secondary" id="button22">Сбросить</a>
            <button class="btn btn-outline-dark" type="submit" id="button2">Поиск</button>
        </div>
    </form>
    <div class="justify-content-center">
        @if(isset($data) && !empty(array_filter($data)))
            @include('result.widgets.resfilter')
        @endif
        @include('result.widgets.lenta')
    </div>

@endsection
