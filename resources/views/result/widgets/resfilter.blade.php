<div class="row">
    <div class="col-12">
        @foreach($arrs_filter as $k1 => $res_arrs)

            <table class="table">
                <thead>
                <tr>
                    @if($k1 === 0)
                        <th scope="col">Сумма</th>
                        <th scope="col">Месяц</th>
                        <th scope="col">Год</th>
                    @else
                        <th scope="col">Сумма</th>
                        <th scope="col">Категория</th>
                        <th scope="col">Год</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach($res_arrs as $res_arr)
                    <tr>

                        @foreach($res_arr as $res_arr1)

                            @foreach($res_arr1 as $res1)
                               <td>{{$res1}}</td>
                            @endforeach

                        @endforeach


                    </tr>
                @endforeach


                </tbody>
            </table>
        @endforeach
    </div>
</div>
