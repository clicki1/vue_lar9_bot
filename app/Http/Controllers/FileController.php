<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('files.index');
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
        $res = $request->all();
        // dd($res);
        //  $res['file'];
        //  dump($request->file('file')->getClientOriginalName());
        //  dump($request->file('file')->getClientOriginalExtension());//png

        if ($request->input('file') && $request->file('file')->getClientOriginalExtension() != 'txt') {
            return view('files.index');
        }

        if ($request->input('arr_check')) {
            $file = File::find($request->input('file_id'));
            $file_array = json_decode($file->array_parsing);
            foreach ($request->input('arr_check') as $key => $value) {
                //  dd(key($value));
                $k = preg_split("/(:|\.|,\s)/", $file_array[key($value)][0]);
                $d = mktime($k[3], $k[4], $k[5], $k[1], $k[0], $k[2]);
                $car = Carbon::createFromTimestamp($d)->toDateTimeString();
                $file_array[key($value)][2] = null;
                $file_array[key($value)][3] = $car;

                //добавление в таблицу

                //


                $c[$key] = Message::where('created_at', $car)->get();
                unset($file_array[key($value)]);
            }

            foreach ($file_array as $k => $value) {
                $message = $value[1];
                $created_at = $value[3];
                $chat_id = '223344';
                $this->service->storeFileMessage($message, $chat_id, $created_at);
                dump($value[1]);
                dd($value[3]);
            }

            //добавление в таблицу
            // $this->service->storeFileMessage($file_array, '112233');
            //

            dump($c);
            dump($res);
            dd($file_array);
        }


        // $path = $request->file('file')->store('file3', 'public');
        // $path = Storage::putFile('public/file1', $request->file('file'));
        $path = $request->file('file')->storeAs(
            'file',
            $request->file('file')->getClientOriginalName(),
            'public'
        );
        dump($path);
        //получаем файл
        $file_upload = Storage::disk('public')->get($path);
        //разбиваем построчно и создаем массив
        $array_file_string = preg_split('/\\r\\n?|\\n/', $file_upload);
        //итоговый массив
        $filter_array = [];
        //итоговый массив ошибочных строк
        $false_array = [];
        //актуальный ключ строки
        $val_key = null;
        $val_fail_key = null;


        foreach ($array_file_string as $k => $value) {
            $value = trim($value);
            $value = preg_replace('/\s*$/', '', $value);
            //ищем ошибки в строках
            $fail_1 = preg_match('/‎/', $value);
            $fail_2 = preg_match('/(\-)/', $value);
            $fail_3 = preg_match('/[a-zA-Z0-9а-яА-Я]*$/', $value);
            $fail_4 = preg_match('/\d\d\d\./', $value);
            $fail_5 = preg_match('/^[a-zA-Z0-9\[а-яА-Я]/', $value);
            $fail_6 = preg_match('/[\?\/\-\+]/', $value);
            $fail_7 = preg_match('/.*:.*:.*:.*:/', $value);
            $fail_8 = preg_match('/[(\d\d)]/', $value);


            if (!$value or $fail_1 or $fail_2 or !$fail_3 or $fail_4 or !$fail_5 or $fail_6 or $fail_7 or !$fail_8) {
                $false_array[] = $value;
                $val_fail_key = $k;
                continue;
            }
            //удаляем первую скобку в каждой строке
            $str_1 = preg_replace('/\[/', '', $array_file_string[$k]);
            //разбиваем строку на подмассив по сторой скобке
            $arr_str = preg_split("/]./", $str_1);
            //формируем итоговый массив
            if (count($arr_str) === 2) {
                //проверяем на наличае числа
                $fail_8 = preg_match('/\d\d/', $arr_str[1]);
                if (!$fail_8) {
                    $val_fail_key = $k;
                    $false_array[] = $value;
                    continue;
                }
                //добавляем данные в актуальный ключ
                $val_key = $arr_str[0];

                //удаляем автора собщения, оставляем только текст
                $arr_str[1] = preg_replace('/.*\:\s/', '', $arr_str[1]);
                //удаляем точку внутри цисла
                $arr_str[1] = preg_replace('/\./', '', $arr_str[1]);
                $arr_str[2] = $value;
                //добавляем формат даты от laravel
                $k = preg_split("/(:|\.|,\s)/", $arr_str[0]);
                $d = mktime($k[3], $k[4], $k[5], $k[1], $k[0], $k[2]);
                $date_laravel = Carbon::createFromTimestamp($d)->toDateTimeString();
                $arr_str[3] = $date_laravel;
                //
            }

            if (count($arr_str) === 1) {
                if (($val_fail_key + 1) === $k) {
                    $val_fail_key = $k;
                    $false_array[] = $value;
                    continue;
                }

                if (count($arr_str) > 2) {
                    $val_fail_key = $k;
                    $false_array[] = $value;
                    continue;
                }
                $arr_str[0] = preg_replace('/\./', '', $arr_str[0]);
                $arr_str[1] = $arr_str[0];
                $arr_str[0] = $val_key;
                $arr_str[2] = $value;
                //добавляем формат даты от laravel
                $k = preg_split("/(:|\.|,\s)/", $arr_str[0]);
                $d = mktime($k[3], $k[4], $k[5], $k[1], $k[0], $k[2]);
                $date_laravel = Carbon::createFromTimestamp($d)->toDateTimeString();
                $arr_str[3] = $date_laravel;
                //
            }

            $filter_array[] = $arr_str;

        }

        dump($false_array);
        $filter_array_json = json_encode($filter_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        // dump($filter_array);
        //    dd($array_file_string);
        //  $path = Storage::disk('public')->delete('file3/i6c4NCGpRDW7Uw2FWyM1WxijvEql1Fwcvo0QErdj.png');
        //   dd($path);
        $path = Storage::disk('public')->put('/files', $res['file']);
        $file = File::create([
            'title' => $request->file('file')->getClientOriginalName(),
            'path' => $path,
            'chat_id' => 111222,
            'array_parsing' => $filter_array_json,
        ]);


        //dd($path);
        return view('files.index', compact('file', 'filter_array'));
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
