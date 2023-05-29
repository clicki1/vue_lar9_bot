<?php

namespace App\Http\Controllers;

use App\Http\Filters\ResultFilter;
use App\Http\Requests\ResultRequest;
use App\Http\Requests\Vue\Result\FilterRequest;
use App\Models\Advertising;
use App\Models\Category;
use App\Models\Message;
use App\Models\Result;
use App\Models\Tag;
use Illuminate\Http\Request;

class ResultController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FilterRequest $request)
    {
//        $adf = Advertising::whereYear('created_at','2021')->orderBy('id', 'asc')->first();
//        $adl = Advertising::whereYear('created_at','2021')->orderBy('id', 'desc')->first();
//        $adn2021 = Advertising::whereYear('created_at','2021')->sum('num');
//        $adn2021m = Advertising::whereYear('created_at','2021')->whereMonth('created_at','12')->sum('num');
//        $adn2021md = Advertising::whereYear('created_at','2021')->whereMonth('created_at','12')->whereDay('created_at','2')->sum('num');
//        $adn2021date = Advertising::whereDate('created_at', '=', '2021-12-7')->sum('num');
//        $adn2022 = Advertising::whereYear('created_at','2022')->sum('num');
        // dump($adn2021date);
        // dd($adn2022);
        // dd($request);

        $arrs = $this->service->resultAll();


        // dd($arrs);

        $data = $request->validated();
        // dd($data);
        $filter = app()->make(ResultFilter::class, ['queryParams' => array_filter($data)]);
        $results = Result::filter($filter)->paginate(10);
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

                $fst = Message::first()->created_at->year;
                $data['year_res'] = $fst;
            }
            if (empty($data['year_res']) && !empty($data['month_res'])) {

                $data['year_res'] = Result::whereMonth('created_at', $data['month_res'])->latest()->first()->created_at->year;
            }
        }



        $arrs_filter = $this->service->resultFilterTable($data, $months, $filter);
      //  dd($arrs_filter[1]);
        return view('result.index', compact('results', 'arrs_filter', 'categories', 'arrs', 'years', 'months', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Result $result
     * @return \Illuminate\Http\Response
     */
    public function show(Result $result)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Result $result
     * @return \Illuminate\Http\Response
     */
    public function edit(Result $result)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Result $result
     * @return \Illuminate\Http\Response
     */
    public function update(ResultRequest $request, Result $result)
    {
        $result->category_id = $request->input('category_id');
        $result->save();
        // dd($request->all());
        return redirect()->route('results.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Result $result
     * @return \Illuminate\Http\Response
     */
    public function destroy(Result $result)
    {
        //
    }
}
