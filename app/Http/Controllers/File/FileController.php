<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends BaseController
{
    public function index(Request $request)
    {
        $chat_id = $request->session()->get('chat_id');
      //  dd($chat_id);
        $files_list = File::where('chat_id', $chat_id)->get();
        return view('files.index', compact('chat_id', 'files_list'));
    }

    public function storefile(Request $request)
    {
        $data = $request->all();
        $chat_id = $request->session()->get('chat_id');
        if ($request->input('file') && $request->file('file')->getClientOriginalExtension() != 'txt') {
            return redirect()->route('files.index');

        }
        if(!$request->file('file')){
            return redirect()->route('files.index');
        }
        $path = $request->file('file')->storeAs(
            'file',
            $request->file('file')->getClientOriginalName(),
            'public'
        );
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
            }
            $filter_array[] = $arr_str;
        }
        $filter_array_json = json_encode($filter_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $path = Storage::disk('public')->put('/files', $data['file']);
      //  dump(end($filter_array)[3]);
       // dd( Carbon::now()->toDateTimeString());
        $file = File::create([
            'title' => $request->file('file')->getClientOriginalName(),
            'path' => $path,
            'chat_id' => $chat_id,
            'array_parsing' => $filter_array_json,
            'first_message_at' => $filter_array[0][3],
            'latest_message_at' => end($filter_array)[3],
        ]);
        return view('files.index', compact('file', 'chat_id', 'filter_array'));
    }
    public function uploadfile(Request $request)
    {
        $chat_id = $request->session()->get('chat_id');

        if(!$request->input('file_id')){
            return redirect()->route('files.index');
        }
        $file = File::find($request->input('file_id'));
        $file_array = json_decode($file->array_parsing);

        if ($request->input('arr_check')) {
            foreach ($request->input('arr_check') as $key => $value) {
                $k = preg_split("/(:|\.|,\s)/", $file_array[key($value)][0]);
                $d = mktime($k[3], $k[4], $k[5], $k[1], $k[0], $k[2]);
                $car = Carbon::createFromTimestamp($d)->toDateTimeString();
                $file_array[key($value)][2] = null;
                $file_array[key($value)][3] = $car;
                unset($file_array[key($value)]);
            }
        }
        foreach ($file_array as $k => $value) {
            $message = $value[1];
            $created_at = $value[3];
            $this->service->storeFileMessage($message, $chat_id, $created_at);
        }
        $file->update(['uploads' => Carbon::now()->toDateTimeString()]);
        return redirect()->route('files.index')->with('info', 'Добавлено в базу данных: '.count($file_array).' записей');
    }
    public function deletefile(Request $request, File $file){
       // dd($file);
        $chat_id = $request->session()->get('chat_id');
      //  $file = File::find($request->input('file_id'));
        if (Storage::disk('public')->exists($file->path)){
            Storage::disk('public')->delete($file->path);
            $file->delete();
            return redirect()->route('files.index')->with('info', 'Фаил удален');
        }
        return redirect()->route('files.index')->with('info', 'Не удалось удалить файл');


    }
}
