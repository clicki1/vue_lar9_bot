@extends('layouts.chartmain')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Итоговая таблица</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th style="width: 10px">Год</th>
                    <th>Январь</th>
                    <th>Февраль</th>
                    <th>Март</th>
                    <th>Апрель</th>
                    <th>Май</th>
                    <th>Июнь</th>
                    <th>Июль</th>
                    <th>Август</th>
                    <th>Сентябрь</th>
                    <th>Октябрь</th>
                    <th>Ноябрь</th>
                    <th>Декабрь</th>
                    <th>Среднее</th>
                    <th>Итого</th>
                </tr>
                </thead>
                <tbody>
                @foreach($arrs as $k => $val)


                    <tr>
                        <td>{{ $k }}</td>
                        @foreach($val as $v)

                            <td>{{ $v }}</td>
                        @endforeach



                    </tr>
                @endforeach


                </tbody>
            </table>
        </div>
    </div>
@endsection

