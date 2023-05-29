<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\St;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class StController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


//
//        $a1=array(1,3,2,3,4);
//
//        $res = array_filter($a1 ,function ($key){
//            return $key === 1;
//        }, ARRAY_FILTER_USE_KEY);
//        dump($res);
//        dd($a1);


        //start
        $test_preg = Storage::get('cat_tag_new.txt');
        $value = preg_replace('/ /', '', $test_preg);
        $arr_car_all = preg_split('/\\r\\n?|\\s\\n|\\n/', $value);
        $cat_tags_array = [];
        foreach ($arr_car_all as $k => $v) {
            if (!$v) continue;
            $v = trim($v);
            $arr_str = [];
            $arr_str = preg_split("/\\t/", $v);
           // dd($arr_str);
            $cat_tags_array[$k][$arr_str[0]] = $arr_str[1];
           // $cat_tags_array[][1] = $arr_str[1];
        }

        dd($cat_tags_array);
        //  $res = preg_replace('/\r\n/', '+++', $test_preg);
        // $res = explode("+++", $res);
        //  $res = preg_replace('/\\r\\n?|\\s\\n|\\n/','***', $test_preg);
        //  dd($res)
        $res = preg_split('/\\r\\n?|\\s\\n|\\n/', $test_preg);
        $res = json_encode($res, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $res = json_decode($res);
        // dd($res);

        $filter_1 = [];
        $out_arr = [];
        $val_key = null;
        foreach ($res as $k => $value) {
            $value = trim($value);
            $value = preg_replace('/\s*$/', '', $value);
            // $value = preg_replace('/\./', '', $value);
            //  $value = preg_replace('/\./', '', $value);
            $d = preg_match('/‎/', $value);
            $w = preg_match('/(\-)/', $value);
            $q = preg_match('/[0-9а-яА-Я]*$/', $value);
            $f = preg_match('/\d\d\d\./', $value);
            //    if ($d) unset($res[$k]);

            if (!$value or $d or $w or !$q or $f) {
                $out_arr[] = $value;
                //  $out_arr[]['d'] = $d;
                //  $out_arr[]['w'] = $w;
                //   $out_arr[]['q'] = !$q;
                if ($f) $out_arr[]['f'] = $f;
                continue;
                //  unset($res[$k]);
            }

            $d = preg_replace('/\[/', '', $res[$k]);

            $arr_str = preg_split("/]./", $d);

            if (count($arr_str) === 2) {
                $val_key = $arr_str[0];
                $arr_str[1] = preg_replace('/.*\:\s/', '', $arr_str[1]);
                $arr_str[1] = preg_replace('/\./', '', $arr_str[1]);
            }
            if (count($arr_str) === 1) {
                $arr_str[0] = preg_replace('/\./', '', $arr_str[0]);
                $arr_str[1] = $arr_str[0];
                $arr_str[0] = $val_key;

            }
            $filter_1[] = $arr_str;

            // dd($arr_str);
            //  dd(count($arr_str));
            // $res = preg_replace('/‎/', '-DELETE-', $test_preg);
            dump($arr_str[1]);
        }

        dump($out_arr);
        // dump($filter_1);
        dd($filter_1);

        $res = json_encode($res, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);


        Storage::disk('local')->put('example.txt', $res);
        $res_st = Storage::get('example.txt');
        $array_res = json_decode($res_st);
        dump($array_res);
        dd($res_st);
        //end


        $cat = Category::all();
        // dd($cat);
        $string_original_1 = '[01.03.2022, 13:03:20] Любимая Моя: Кукушка 350';

        $string_original_2 = '[01.03.2022, 13:03:20] Любимая Моя: Кукушка 350
Продукты 160
Маникюр 700
Быт химия 550
[01.03.2022, 18:43:40] Любимая Моя: Продукты 180';

        $string_to_parse = '[01.03.2022, 18:43:40] Любимая Моя: Продукты 180
[02.03.2022, 13:06:46] Любимая Моя: Продукты 300
Продукты 300
Продукты 350
Быт химия 300
[02.03.2022, 15:16:21] Любимая Моя: МТС 300
[02.03.2022, 19:16:48] Александр Юрьевич: Вода 30';

        $string = 'The quick brown fox jumps over the lazy dog.';
        $patterns = array();
        $patterns[0] = '/quick/';
        $patterns[1] = '/brown/';
        $patterns[2] = '/fox/';
        $replacements = array();
        $replacements[2] = 'bear';
        $replacements[1] = 'black';
        $replacements[0] = 'slow';
        ksort($patterns);
        ksort($replacements);
        dd(preg_replace($patterns, $replacements, $string));

        $string_2 = '[["01.03.2022, 13:03:20"], "Любимая Моя: Кукушка 350",
"Продукты 160",
"Маникюр 700",
"Быт химия 550"]';//+


        $string_3 = '[[["01.03.2022, 13:03:20"], "Любимая Моя: Кукушка 350",
"Продукты 160",
"Маникюр 700",
"Быт химия 550"],
[["01.03.2022, 18:43:40"], "Любимая Моя: Продукты 180"],
[["02.03.2022, 19:16:48"], "Александр Юрьевич: Вода 30"]]';//+

        $string2 = '[["01.03.2022, 13:03:20"], "Любимая Моя: Кукушка 350"]';//+

        $string3 = '[
        ["01.03.2022, 13:03:20"],
         ["Любимая Моя: Кукушка 350"]
         ]'; //+

        $arr = [
            [
                'created_at' => Carbon::now(),
                'username' => "Александр Юрьевич",
                'message' => "Бензин 2550"
            ], [
                'created_at' => Carbon::now(),
                'username' => "Александр Юрьевич",
                'message' => "Кофе 130"
            ],
        ];
        //  $st = Storage::disk('local')->put('example.txt', json_encode($string, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $st = Storage::disk('local')->put('example.txt', $string_3);
        // $st = Storage::put('example.txt', json_encode($arr, JSON_UNESCAPED_UNICODE));
        $contents = Storage::get('example.txt');
        //добавляем в начало файл
        // $prep =  Storage::prepend('example.txt', 'Prepended Text');
        //добавляем в конец файла
        //  $append =  Storage::append('example.txt', 'Appended Text');
// Явно указать имя файла ...

        $path = Storage::disk('local')->path('example.txt');
        if (Storage::disk('local')->exists('example.txt')) {

            dump($path);
//            dump($prep);
//            dump($append);

            dump(json_decode($contents));
            //  $contents1 = Storage::get('example.txt');
            //  dump($contents1);
            dd($contents);
        }
        dd(111);
        $mutable = Carbon::now();
//        dump(md5('12345678'));
//        dd($mutable->add(-1, 'day'));

        // $sts = St::all();
        // return view('layouts.test', compact('sts'));
        return view('layouts.yamusic');
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


        $data = $request->all();
        $data['file'] = Storage::disk('public')->put('/images', $data['file']);

        $res = St::firstOrCreate([
            'file' => $data['file']
        ], $data);

        $sts = St::all();
        return view('layouts.test', compact('sts'));

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
