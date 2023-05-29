<?php

namespace App\Http\Controllers\Vue\Graphic;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Filters\ResultFilter;
use App\Http\Requests\Vue\Result\FilterRequest;
use App\Models\Category;
use App\Models\Message;
use App\Models\Result;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(FilterRequest $request)
    {

        $chat_id = $request->session()->get('chat_id');

        $arrs = $this->service->resultAllApi($chat_id);


        $data = $request->validated();
        // dd($data);
        $filter = app()->make(ResultFilter::class, ['queryParams' => array_filter($data)]);
        $results = Result::filter($filter)->where('chat_id', $chat_id)->paginate(10);
        $categories = Category::all();

        $years = array_keys($arrs);
        $months = [
            '1' => 'Январь',
            '2' => 'Февраль',
            '3' => 'Март',
            '4' => 'Апрель',
            '5' => 'Май',
            '6' => 'Июнь',
            '7' => 'Июль',
            '8' => 'Август',
            '9' => 'Сентябрь',
            '10' => 'Октябрь',
            '11' => 'Ноябрь',
            '12' => 'Декабрь'
        ];


        if (isset($data) && !empty(array_filter($data) && empty($data['err_cat']))){
            if (empty($data['year_res']) && empty($data['month_res'])) {

                $fst = Message::where('chat_id', $chat_id)->first()->created_at->year;
                $data['year_res'] = $fst;
            }
            if (empty($data['year_res']) && !empty($data['month_res'])) {

                $data['year_res'] = Result::where('chat_id', $chat_id)->whereMonth('created_at', $data['month_res'])->latest()->first()->created_at->year;
            }
        }


        $res = array();
        $res['arrs_filter'] = $this->service->resultFilterTable($data, $months, $filter, $chat_id);
        $res['categories'] = $categories;
        $res['arrs'] = $arrs;
        $res['years'] = $years;
        $res['months'] = $months;
        $res['data'] = $data;

        return response($res);
    }
}
