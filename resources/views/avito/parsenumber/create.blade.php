@extends('layouts.main_free')
@section('content')
    <div class="row m-4">
        <div class="col-12">
            <h3>Добавте картинку с телефоном с сайта Авито</h3>
            <form action="{{route('avito.storeimgphone')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="input-group">

                    <input type="file" name="file" class="form-control" id="inputGroupFile04"
                           aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                    <button class="btn btn-outline-secondary" type="submit" id="inputGroupFileAddon04">Загрузить файл
                    </button>
                </div>
            </form>
        </div>
    </div>
    @isset($path)
        <div class="row m-4">
            <div class="col-12">
                <img src="{{asset('storage/'.$path)}}" alt="">
                <h3>{{$result_phone}}</h3>
                <form action="{{route('avito.addimgphone')}}" method="post">
                    @csrf
                    <input type="text" name="file_path" value="{{$path}}" hidden>
                    <div class="input-group mb-3">

                        <input type="number" name="number[0]" class="form-control">
                        <span class="input-group-text"> </span>
                        <input type="number" name="number[1]" class="form-control">
                        <input type="number" name="number[2]" class="form-control">
                        <input type="number" name="number[3]" class="form-control">
                        <span class="input-group-text"> </span>
                        <input type="number" name="number[4]" class="form-control">
                        <input type="number" name="number[5]" class="form-control">
                        <input type="number" name="number[6]" class="form-control">
                        <span class="input-group-text">-</span>
                        <input type="number" name="number[7]" class="form-control">
                        <input type="number" name="number[8]" class="form-control">
                        <span class="input-group-text">-</span>
                        <input type="number" name="number[9]" class="form-control">
                        <input type="number" name="number[10]" class="form-control">
                        <button class="btn btn-outline-secondary" type="submit" id="input_res">Обработать</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

@endsection
