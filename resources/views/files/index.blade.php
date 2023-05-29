@extends('layouts.main_free')
@section('content')

    <h2 class="d-flex justify-content-between align-items-center mt-3">
        <span class="text-secondary">Чат: {{ $chat_id }}

        </span>
        <span class="text-primary"><a class="btn btn-sm btn-success"
                                      href="{{route('vue.base')}}">Перейти в чат</a></span>
        <span class="text-primary"><a class="btn btn-sm btn-danger"
                                      href="{{route('chat.logout')}}">Выйти чата</a></span>

    </h2>
    @if(session('info'))
        <h4 class="badge bg-primary rounded-pill">{{ session('info') }}</h4>
    @endif
    <h4 class="d-flex justify-content-between align-items-center mt-3">
        <span class="text-primary">Загрузите файлы</span>

    </h4>
    <form action="{{route('files.storefile')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="input-group">

            <input type="file" name="file" class="form-control" id="inputGroupFile04"
                   aria-describedby="inputGroupFileAddon04" aria-label="Upload">
            <button class="btn btn-outline-secondary" type="submit" id="inputGroupFileAddon04">Загрузить файл</button>
        </div>
    </form>
    @if(isset($file))
        <div class="row">
            <div class="col-12">
                <h3>Фаил: {{$file->title}}</h3>
                <h5>Количество записей: {{count($filter_array)}}</h5>
                <h5>ВЫберите поля которые нужно удалить:</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form action="{{route('files.uploadfile')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="file_id" value="{{$file->id}}" hidden>

                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Удалить</th>
                            <th scope="col">Сообщение</th>
                            <th scope="col">Дата</th>
                            <th scope="col">Исходное сообщение</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($filter_array as $k => $arr_res)
                            <tr>
                                <th scope="row">{{$k+1}}</th>
                                <td> <input class="form-check-input" name="arr_check[][{{$k}}]" type="checkbox"
                                            value="{{ $arr_res[1]}}" id="flexCheckChecked_{{$k}}"></td>
                                <td> <label class="form-check-label" for="flexCheckChecked_{{$k}}">
                                        {{ $arr_res[1]}}
                                    </label></td>
                                <td><label class="form-check-label" for="flexCheckChecked_{{$k}}">
                                        {{ $arr_res[3]}}
                                    </label></td>
                                <td><label class="form-check-label" for="flexCheckChecked_{{$k}}">
                                        {{ $arr_res[2]}}
                                    </label></td>
                            </tr>
                        @endforeach
                        <tr>
                            <th scope="row">#</th>

                            <td colspan="4"><button class="btn btn-lg btn-danger" type="submit" id="del_id_button">Удалить выбранные
                                    данные и добавить данные в БД
                                </button></td>
                        </tr>
                        </tbody>
                    </table>



                </form>

            </div>
        </div>

    @endif
    @if(isset($files_list))
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Файд</th>
                <th scope="col">Первое сообщение</th>
                <th scope="col">Последнее сообщение</th>
                <th scope="col">Загружено</th>
                <th scope="col">Удалить файл</th>
            </tr>
            </thead>
            <tbody>
            @foreach($files_list as $key => $file)
            <tr>
                <th scope="row">{{$key+1}}</th>
                <td>{{$file->title}}</td>
                <td>{{$file->first_message_at}}</td>
                <td>{{$file->latest_message_at}}</td>
                <td>{{$file->uploads}}</td>
                <td><a  class="btn btn-outline-danger" href="{{ route('files.deletefile', ['file' => $file->id]) }}">Удалить</a></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection
