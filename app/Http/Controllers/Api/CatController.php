<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category\TagResourse;
use App\Models\Category;
use Illuminate\Http\Request;

class CatController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $data = $request->all();
        $message = mb_strtolower(($data['message'] ? $data['message'] : $data['message']), 'utf-8');
        $res_str = array();
        $num = array();
        $new_mess = explode("\n", $message);
        if(count($new_mess) > 1){
            foreach ($new_mess as $k => $narr){
                $new2 = explode(" ", $narr);
                $res_str[$k][0] = "";
                $num[$k][0] = 0;
                $nc = 0;
                $sc = 0;
                foreach ($new2 as $k1 => $arr) {



                        !is_numeric($arr) ? $res_str[$k][$sc] .= " " . $arr : $num[$k][$nc] = $arr;
                    $nc++;
                    $sc++;



                  //  return $k;
                  //  !is_numeric($arr) ? $res_str[$k] .= " " . $arr : $num[$k] = $arr;
                   // return $num;
                    // $res .= '-'.$arr;
                }
                $nc = 0;
                $ns = 0;
            }
        }
        return $num;
    }
}
