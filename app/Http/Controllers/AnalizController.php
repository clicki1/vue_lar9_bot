<?php

namespace App\Http\Controllers;

use App\Models\Advertising;
use Illuminate\Http\Request;

class AnalizController extends BaseController
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $arrs = [];
        $fst = Advertising::first()->created_at->year;
        $lst = Advertising::latest()->first()->created_at->year;
       // $allyear = Advertising::all()->pluck('id');


        for ($y = $fst; $y <= $lst; $y++) {
            for ($i = 0; $i < 12; $i++) {
                $arrs[$y][$i] = Advertising::whereYear('created_at', $y)->whereMonth('created_at', $i + 1)->sum('num');
                if($i == 11){
                    $sum = Advertising::whereYear('created_at', $y)->sum('num');
                    $arrs[$y][$i+1] = round($sum/12);
                    $arrs[$y][$i+2] = $sum;
                }
            }
        }
       // dd($arrs);
        return view('analiz.index', compact('arrs'));
    }
}
