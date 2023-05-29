<!-- /.card-header -->
<div class="card-body">
    <table class="table table-sm table-bordered table-secondary  table-striped">
        <thead>
        <tr class="table-primary">
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

            <tr class="table-success">
                <td  class="table-info">{{ $k }}</td>


                @foreach($val as $k1 => $varr)
                    @if($k1 < 12)



                        <td >
                            <ul class="list-group">
                                @foreach($varr as $k2 => $v)

                                    <li class="list-group-item">{{ $k2 }}: {{ $v }}</li>
                                @endforeach

                            </ul>

                        </td>
                    @else
                        <td>{{ $varr }}</td>
                    @endif
                @endforeach


            </tr>
        @endforeach


        </tbody>
    </table>
</div>
