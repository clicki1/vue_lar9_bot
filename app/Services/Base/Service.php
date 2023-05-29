<?php

namespace App\Services\Base;

use App\Models\Category;
use App\Models\Message;
use App\Models\Result;
use App\Models\Tag;
use App\Models\Tgmessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class Service
{

    // public $telegram;
    public function createBotMessage($chat_id, $tgmessage_id, $message)
    {
        return Tgmessage::create([
            'chat_id' => $chat_id,
            'tgmessage_id' => $tgmessage_id,
            'text' => $message
        ]);
    }

    public function deleteBotMessageAll($chat_id)
    {
        $tg_mess =  Tgmessage::where('chat_id', $chat_id)->get();
        //  ->where('text', '!=', 'keys')
        //   ->delete();
        foreach ($tg_mess as $ms) {
            $this->telegram->deleteMessage($chat_id, $ms->tgmessage_id);
            $ms->delete();
            return 200;
        }
    }

    public function storeMessageNew($data)
    {
        //  dd(getenv('APP_URL'));
        $data['message'] = mb_strtolower(($data['message'] ? $data['message'] : $data['message']), 'utf-8');
        $str_arr = explode("\n", $data['message']);
        // dd($messages);
        $data['chat_id'] = 4449;

        $chat = \App\Models\Chat::firstOrCreate(
            ['chat_id' => $data['chat_id']],
            [
                'chat_id' => $data['chat_id'],
                'key' => md5($data['chat_id'] + time())
            ],
        );


        $mess = Message::create([
            //  'chat_id' => $chat->chat_id,
            'message' => $data['message'],
        ]);
        // dd($mess->id);
        foreach ($str_arr as $message) {
            $message = trim($message);
            if (isset($data['username'])) unset($data['username']);

            $new_arr = explode(" ", $message);
            $res_str = '';
            $num = '';
            $cat = null;

            foreach ($new_arr as $arr) {
                !is_numeric($arr) ? $res_str .= " " . $arr : $num = $arr;

                if (!$cat) {

                    $cat = Category::where('title', $arr)->first();

                    if (!$cat) {
                        $tag = Tag::where('title', $arr)->first();

                        if ($tag && !$cat) {
                            $cat = $tag->category;
                        }
                    }

                }
            }
            $res_str = trim($res_str);

            if (!$num) {
                $num = 0;
            }

            $res = new Result();
            $res->coast = $num;
            $res->message_id = $mess->id;
            // $res->created_at = $data['created_at'];
            if ($cat) {
                $res->category_id = $cat->id;
            }
            $res->save();

        }

        return ['Запись добавлена', ''];
    }

    public function storeMessage($data)
    {

        $messages = mb_strtolower(($data['message'] ? $data['message'] : $data['message']), 'utf-8');
        $str_arr = explode("\n", $messages);

        foreach ($str_arr as $message) {
            //start
            $message = trim($message);

            try {
                DB::beginTransaction();

                if (isset($data['username'])) unset($data['username']);

                $new_arr = explode(" ", $message);
                $res_str = '';
                $num = '';
                $cat = null;

                foreach ($new_arr as $arr) {
                    !is_numeric($arr) ? $res_str .= " " . $arr : $num = $arr;

                    if (!$cat) {

                        $cat = Category::where('title', $arr)->first();

                        if (!$cat) {
                            $tag = Tag::where('title', $arr)->first();

                            if ($tag && !$cat) {
                                $cat = $tag->category;
                            }
                        }

                    }
                }
                $res_str = trim($res_str);
                if (!$res_str) {

                    return ['Ошибка: отсутствует тектстовое значение на одной строк', $message];
                }
                if (!$num) {

                    return ['Ошибка: отсутствует числовое значение на одной строк', $message];
                }
                $mess = Message::create(['message' => $message]);

                $res = Result::where('message_id', $mess->id)->first();

                if (!$res) {

                    $res = new Result();
                    $res->coast = $num;
                    $res->message_id = $mess->id;
                    // $res->created_at = $data['created_at'];
                    if ($cat) {
                        $res->category_id = $cat->id;
                    }

                    $res->save();
                }


                DB::commit();
            } catch (\Exception $exception) {
                DB::rollBack();
                return [$exception->getMessage(), $message];

            }


            //finish
        }

        // dd($mess);
        return ['Запись добавлена', ''];

    }

    public function storeFileMessage($text, $chat_id, $created_at)
    {
        //проверяем chat_id
        $chat = \App\Models\Chat::firstOrCreate(
            ['chat_id' => $chat_id],
            [
                'chat_id' => $chat_id,
                'key' => md5($chat_id + time())
            ],
        );
        //  dumb($created_at);
        //  dd($mess);
        //проверяем на наличае данной записи в таблице
        $mess = Message::firstOrCreate([
            'created_at' => $created_at,
            'chat_id' => $chat->chat_id
        ], [
            'message' => $text,
            'created_at' => $created_at,
            'chat_id' => $chat_id
        ]);
        //приводим строку к нижнему регитстру
        $text = mb_strtolower(($text), 'utf-8');
        //разбиваем строку
        $arr_txt = explode(" ", $text);
        //переменная строчных символов
        $res_str = '';
        //переменная числовых символов
        $num = 0;
        //переменная категории
        $cat = null;
        //
        $category_id = null;

        foreach ($arr_txt as $value) {
            $value = trim($value);
            //проверяем значение на наличае числа
            !is_numeric($value) ? $res_str .= " " . $value : $num = $value;
            //ищем категорию по тегу
            if (!$cat) {
                $cat = Category::where('title', $value)->first();
                if (!$cat) {
                    $tag = Tag::where('title', $value)->first();
                    if ($tag && !$cat) {
                        $cat = $tag->category;
                    }
                }
            }
        }
        //проверяем нашлась ли категория
        if ($cat) {
            $category_id = $cat->id;
        }
        //добавляем в таблицу результат
        $result = Result::firstOrCreate([
            'created_at' => $created_at,
            'chat_id' => $chat->chat_id
        ], [
            'coast' => $num,
            'message_id' => $mess->id,
            'created_at' => $created_at,
            'chat_id' => $chat_id,
            'category_id' => $category_id
        ]);


    }


    public function updateMessageNewTg($data, $message)
    {
        $message_upd_tg = Message::where('tgmessage_id', $message->tgmessage_id)
            ->where('chat_id', $message->chat_id)
            ->where('id', $message->id)
            ->first();

        if (!$message_upd_tg) {
            return false;
        }


        $messages = mb_strtolower(($data['message'] ? $data['message'] : $data['message']), 'utf-8');
        $str_arr = explode("\n", $messages);

        $message_upd_tg->results()->delete();

        $message_upd_tg->checked_id = 111;
        $message_upd_tg->message = $messages;
        $message_upd_tg->save();

        // return dd($message_upd_tg);

        foreach ($str_arr as $message_upd) {
            $message_upd = trim($message_upd);
            if (isset($data['username'])) unset($data['username']);

            $new_arr = explode(" ", $message_upd);
            $res_str = '';
            $num = '';
            $cat = null;

            foreach ($new_arr as $arr) {
                !is_numeric($arr) ? $res_str .= " " . $arr : $num = $arr;

                if (!$cat) {

                    $cat = Category::where('title', $arr)->first();

                    if (!$cat) {
                        $tag = Tag::where('title', $arr)->first();

                        if ($tag && !$cat) {
                            $cat = $tag->category;
                        }
                    }

                }
            }

            if (!$num) {
                $num = 0;
            }

            $res = new Result();
            $res->coast = $num;
            $res->chat_id = -123123;
            $res->message_id = $message_upd_tg->id;
            $res->created_at = $message_upd_tg->created_at;
            //  $res->updated_at = $message->created_at;
            if ($cat) {
                $res->category_id = $cat->id;
            }
            $res->save();

        }

        return true;
    }

    public function updateMessageNew($data, $message)
    {
        //$results = Result::where('message_id', $message->id)->get();
        $messages = mb_strtolower(($data['message'] ? $data['message'] : $data['message']), 'utf-8');
        $str_arr = explode("\n", $messages);
        // dd($messages);

        $mess = Message::create([
            'message' => $messages,
            'created_at' => $message->created_at,
            //  'updated_at ' => $message->created_at
        ]);
        // dd($mess->id);
        foreach ($str_arr as $message_upd) {
            $message_upd = trim($message_upd);
            if (isset($data['username'])) unset($data['username']);

            $new_arr = explode(" ", $message_upd);
            $res_str = '';
            $num = '';
            $cat = null;

            foreach ($new_arr as $arr) {
                !is_numeric($arr) ? $res_str .= " " . $arr : $num = $arr;

                if (!$cat) {

                    $cat = Category::where('title', $arr)->first();

                    if (!$cat) {
                        $tag = Tag::where('title', $arr)->first();

                        if ($tag && !$cat) {
                            $cat = $tag->category;
                        }
                    }

                }
            }
            $res_str = trim($res_str);

            if (!$num) {
                $num = 0;
            }

            $res = new Result();
            $res->coast = $num;
            $res->message_id = $mess->id;
            $res->created_at = $message->created_at;
            //  $res->updated_at = $message->created_at;
            if ($cat) {
                $res->category_id = $cat->id;
            }
            $res->save();


        }
        $message->results()->delete();
        $message->delete();

        return ['Запись обновлена', ''];
    }


    public function updateMessage($data, $message)
    {


        try {
            DB::beginTransaction();
            // $data['message'] = trim($data['message']);

            $new_arr = explode(" ", $data['message']);
            $res_str = '';
            $num = '';
            $cat = null;

            foreach ($new_arr as $arr) {
                !is_numeric($arr) ? $res_str .= " " . $arr : $num = $arr;

                if (!$cat) {

                    $cat = Category::where('title', $arr)->first();

                    if (!$cat) {
                        $tag = Tag::where('title', $arr)->first();

                        if ($tag && !$cat) {
                            $cat = $tag->category;
                        }
                    }

                }
            }

            $res_str = trim($res_str);
            if (!$res_str) {

                return ['Ошибка: отсутствует тектстовое значение на одной строк', $message];
            }
            if (!$num) {

                return ['Ошибка: отсутствует числовое значение на одной строк', $message];
            }

            $message->update($data);
            $message->result->update(['coast' => $num]);
            DB::commit();
            return ['Внесены изменения'];

        } catch (\Exception $exception) {
            DB::rollBack();
            return [$exception->getMessage(), $message];

        }

    }

    public function storeCategory($data)
    {

        $category = Category::firstOrCreate([
            'title' => $data['title'],
        ], $data);
        return $category;
    }

    public function updateCategory($data, $category)
    {

        //    $cat = Category::where('title', $data['title'])->withTrashed()->first();
        $category->update($data);
//        if (isset($cat->id)) {
//            $cat->restore();
//            $cat->tags()->restore();
//            $category->forceDelete();
//        } else {
//            $category->update($data);
//        }

        return $category->fresh();
    }

    public function storeTag($data)
    {

        $tag = Tag::firstOrCreate([
            'title' => $data['title'],
        ], $data);
        return $tag;
    }

    public function updateTag($data, $tag)
    {
        if (isset($data['tag_id'])) {
            unset($data['tag_id']);
        }
        $tag->update($data);
        return $tag->fresh();
    }

    public function resultFilter($data, $months, $filter)
    {
        $arrs_filter = [];
        //  $fst_month = Result::whereMonth('created_at', 9)->first()->created_at->year;
//           $lst_month_year = Result::whereMonth('created_at', 1)->latest()->first()->created_at->year;
        // dd($fst_month);
        $fst = Message::first()->created_at->year;
        if (isset($data) && !empty(array_filter($data))) {

            if (empty($data['err_cat'])) {

                if (empty($data['year_res']) && empty($data['month_res'])) {
                    $data['year_res'] = $fst;
                }
                if (empty($data['year_res']) && !empty($data['month_res'])) {
                    $data['year_res'] = Result::whereMonth('created_at', $data['month_res'])->latest()->first()->created_at->year;
                }
                $results_flts = Result::filter($filter)->get();


                //  dd($results_flts->sum('coast'));
                foreach ($results_flts as $res) {
                    if (empty($data['month_res'])) {
                        $x = 1;
                        while ($x < 13) {
                            $query = Result::query();
                            if (!empty($data['category_id'])) {
                                $arrs_filter['Сумма'][$x] = $query->whereYear('created_at', $data['year_res'])
                                    ->whereMonth('created_at', $x)
                                    ->where('category_id', $data['category_id'])->sum('coast');
                                $arrs_filter['Категория'][$x] = Category::find($data['category_id'])->title;

                            } else {
                                $arrs_filter['Сумма'][$x] = $query->whereYear('created_at', $data['year_res'])
                                    ->whereMonth('created_at', $x)->sum('coast');
                            }


                            $arrs_filter['Месяц'][$x] = $months[$x];
                            $arrs_filter['Год'][$x] = $data['year_res'];
                            $x++;

                        }
//                        }
                        //   dd($arrs_filter);
                    }
                    if (!empty($data['month_res'])) {
                        $categories = Category::all();

                        foreach ($categories as $category) {
                            $query = Result::query();
                            if (empty($arrs_filter['Сумма'][0])) {
                                $arrs_filter['Сумма'][0] = $query->whereYear('created_at', $data['year_res'])
                                    ->whereMonth('created_at', $data['month_res'])
                                    ->where('category_id', $data['category_id'])->sum('coast');
                            }
                            $arrs_filter['Сумма'][$category->id] = $query->whereYear('created_at', $data['year_res'])
                                ->whereMonth('created_at', $data['month_res'])
                                ->where('category_id', $category->id)->sum('coast');
                        }

                        $null_cat = Result::whereYear('created_at', $data['year_res'])
                            ->whereMonth('created_at', $data['month_res'])
                            ->where('category_id', null)->sum('coast');

                        array_push($arrs_filter['Сумма'], $null_cat);

                        //   dd($arrs_filter);
                    }


                };

            }
        }
        return $arrs_filter;
    }

    public function resultFilterTable($data, $months, $filter, $chat_id)
    {
        $arrs_filter = [];
        // $fst = Message::first()->created_at->year;
        if (isset($data) && !empty(array_filter($data))) {

            if (empty($data['err_cat'])) {


                // $results_flts = Result::filter($filter)->get();
                if (empty($data['month_res'])) {

                    //нет месяца, год начальный
                    if (empty($data['category_id'])) {
                        //нет месяца и категории, ГОД ЕСТЬ

                        foreach ($months as $k => $mon) {
                            //перебираем месяцы - 13 строк
                            if (empty($arrs_filter[0][0])) {

                                $sum = Result::where('chat_id', $chat_id)->whereYear('created_at', $data['year_res'])->sum('coast');
                                $arrs_filter[0][0] = array();
                                array_push($arrs_filter[0][0], [$sum, 'Всего', $data['year_res']]);
                            }

                            $sum = Result::where('chat_id', $chat_id)->whereYear('created_at', $data['year_res'])
                                ->whereMonth('created_at', $k)->sum('coast');
                            $arrs_filter[0][$k + 1] = array();
                            array_push($arrs_filter[0][$k + 1], [$sum, $mon, $data['year_res']]);


                        }
                        foreach (Category::all() as $k => $cat) {
                            //перебираем категории - категории + 2 строки
                            if (empty($arrs_filter[1][0])) {
                                $arrs_filter[1][0] = array();
                                $sum = Result::where('chat_id', $chat_id)->whereYear('created_at', $data['year_res'])->sum('coast');
                                array_push($arrs_filter[1][0], [$sum, $cat->title, $data['year_res']]);
                            }

                            $sum = Result::where('chat_id', $chat_id)->whereYear('created_at', $data['year_res'])
                                ->where('category_id', $cat->id)->sum('coast');

                            $arrs_filter[1][$k + 1] = array();
                            array_push($arrs_filter[1][$k + 1], [$sum, $cat->title, $data['year_res']]);

                            // $arrs_filter[1];
                        }
                    }
                    if (!empty($data['category_id'])) {
                        //нет месяца, есть категория и  ГОД ЕСТЬ
                        foreach ($months as $k => $mon) {
                            //перебираем месяцы - 13 строк
                            if (empty($arrs_filter[0][0])) {

                                $sum = Result::where('chat_id', $chat_id)->whereYear('created_at', $data['year_res'])
                                    ->where('category_id', $data['category_id'])->sum('coast');
                                $arrs_filter[0][0] = array();
                                array_push($arrs_filter[0][0], [$sum, 'Всего', $data['year_res']]);
                            }

                            $sum = Result::where('chat_id', $chat_id)->whereYear('created_at', $data['year_res'])
                                ->whereMonth('created_at', $k)
                                ->sum('coast');
                            $arrs_filter[0][$k + 1] = array();
                            array_push($arrs_filter[0][$k + 1], [$sum, $mon, $data['year_res']]);


                        }
                    }
                }


                if (!empty($data['month_res'])) {
                    //есть месяц и год
                    if (empty($data['category_id'])) {
                        //есть месяц и год, нет категории
                        foreach (Category::all() as $k => $cat) {
                            //перебираем категории - категории + 2 строки
                            if (empty($arrs_filter[0][0])) {
                                $arrs_filter[1][0] = array();
                                $sum = Result::where('chat_id', $chat_id)->whereYear('created_at', $data['year_res'])
                                    ->whereMonth('created_at', $data['month_res'])->sum('coast');
                                array_push($arrs_filter[1][0], [$sum, 'Итого', $data['year_res']]);
                            }

                            $sum = Result::where('chat_id', $chat_id)->whereYear('created_at', $data['year_res'])
                                ->whereMonth('created_at', $data['month_res'])
                                ->where('category_id', $cat->id)->sum('coast');

                            $arrs_filter[1][$k + 1] = array();
                            array_push($arrs_filter[1][$k + 1], [$sum, $cat->title, $data['year_res']]);

                            // $arrs_filter[1];
                        }

                    }
                    if (!empty($data['category_id'])) {
                        //есть месяц и год и категория
                        $sum = Result::where('chat_id', $chat_id)->whereYear('created_at', $data['year_res'])
                            ->whereMonth('created_at', $data['month_res'])
                            ->where('category_id', $data['category_id'])
                            ->sum('coast');
                        $mon = $months[$data['month_res']];
                        $arrs_filter[0][0] = array();
                        array_push($arrs_filter[0][0], [$sum, $mon, $data['year_res']]);

                    }

                }

            }

        }

        return $arrs_filter;
    }

    public function resultAllApi($chat_id)
    {
        $arrs = [];
        $fst = Message::orderBy('created_at')->where('chat_id', $chat_id)->first()->created_at->year;
        $lst = Message::orderByDesc('created_at')->where('chat_id', $chat_id)->first()->created_at->year;

        for ($y = $fst; $y <= $lst; $y++) {
            for ($i = 0; $i < 12; $i++) {
                $arrs[$y][$i] = Result::where('chat_id', $chat_id)->whereYear('created_at', $y)->whereMonth('created_at', $i + 1)->sum('coast');

                if ($i == 11) {
                    $sum = Result::where('chat_id', $chat_id)->whereYear('created_at', $y)->sum('coast');
                    $arrs[$y][$i + 1] = round($sum / 12);
                    $arrs[$y][$i + 2] = $sum;
                }
            }
        }

        return $arrs;
    }

    public function resultAll()
    {
        $arrs = [];
        $fst = Message::first()->created_at->year;
        $lst = Message::latest()->first()->created_at->year;

        for ($y = $fst; $y <= $lst; $y++) {
            for ($i = 0; $i < 12; $i++) {
                $arrs[$y][$i]['Ит'] = Result::whereYear('created_at', $y)->whereMonth('created_at', $i + 1)->sum('coast');
                $arrs[$y][$i]['Пр'] = Result::whereYear('created_at', $y)
                    ->whereMonth('created_at', $i + 1)
                    ->where('category_id', '4')->sum('coast');
                $arrs[$y][$i]['Нп'] = Result::whereYear('created_at', $y)
                    ->whereMonth('created_at', $i + 1)
                    ->where('category_id', '7')->sum('coast');
                if ($i == 11) {
                    $sum = Result::whereYear('created_at', $y)->sum('coast');
                    $arrs[$y][$i + 1] = round($sum / 12);
                    $arrs[$y][$i + 2] = $sum;
                }
            }
        }

        return $arrs;
    }


}
