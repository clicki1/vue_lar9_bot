<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Advertising;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        // $adv = Advertising::all()->pluck(['craeted_at', 'message']);
        //  return $request->all();
        $all_data = $request->all();
        //  dd($all_data);
        $all_num = 0;
        foreach ($all_data as $data) {
          //  unset($data['username']);

            // dd($data);
            $message = mb_strtolower(($data['message'] ? $data['message'] : $data['message']), 'utf-8');
            $k = preg_split("/(:|\.|,\s)/", $data['created_at']);
            $d = mktime($k[3], $k[4], $k[5], $k[1], $k[0], $k[2]);
            $car = Carbon::createFromTimestamp($d)->toDateTimeString();
            // dump($message);
            // dump($car);
            $new_arr = explode(" ", $message);
            $res_str = '';
            $num = '';
            foreach ($new_arr as $arr) {
                !is_numeric($arr) ? $res_str .= " " . $arr : $num = $arr;
                // $res .= '-'.$arr;
            }
             $res_str = trim($res_str);
             $data['num'] = $num;
             $data['text'] = $res_str;
            $data['created_at'] = $car;
            $all_num += $num;
            $ad = Advertising::firstOrCreate([
                'message' => $data['message'],
                'created_at' => $data['created_at']
            ], $data);


            //  $k = preg_split("/(:|\.|,\s)/", $request->input('0.date'));
            //  $d = mktime($k[3],$k[4],$k[5],$k[1],$k[0],$k[2]);
            // $howOldAmI = Carbon::createFromDate(1975, 5, 21)->age;
            // $car = Carbon::createFromTimestamp($d)->toDateTimeString();
            //  return Carbon::parse($car)->timestamp;
            // return date('Y-m-d', $d);
            // return $request->collect('*.date');
            //return $request->input('message.text');
            // return $request->only(['message', 'update_id']);
        }
        $adv = Advertising::all()->pluck('id');
        return $adv;

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
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
