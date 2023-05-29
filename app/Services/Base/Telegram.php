<?php

namespace App\Services\Base;


use App\Models\Category;
use App\Models\Message;
use App\Models\Result;
use App\Models\Tgmessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class Telegram
{

    protected $http;
    protected $bot;
    public $months = [
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

    const buttons = [
        'resize_keyboard' => true,
        // 'one_time_keyboard' => false,
        'keyboard' => [
            [
                [
                    'text' => 'Расходы в этом году',
                    'callback_data' => '1',
                ],
                [
                    'text' => 'Расходы в прошлом месяце',
                    'callback_data' => '2',
                ]
            ],
            [
                [
                    'text' => 'Расходы в этом месяце',
                    'callback_data' => '3',
                ],
                [
                    'text' => 'Сайт',
                    'callback_data' => '4',
                ],
            ],
        ]
    ];
    const url = 'https://api.telegram.org/bot';

    public function __construct(Http $http, $bot)
    {
        $this->http = $http;
        $this->bot = $bot;

    }



    function sendMessage($chat_id, $message)
    {
        return $this->http::post(self::url . $this->bot . '/sendMessage',
            [
                'chat_id' => $chat_id,
                'text' => '<i> -' . $message . '- </i>',
                'parse_mode' => 'html',
            ]);


    }

    function editMessage($chat_id, $message, $message_id)
    {
        return $this->http::post(self::url . $this->bot . '/editMessageText',
            [
                'chat_id' => $chat_id,
                'message_id' => $message_id,
                'text' => '<i> -' . $message . '- EDIT </i>',
                'parse_mode' => 'html',
            ]);
    }

    function sendButton($chat_id, $message, $button = self::buttons)
    {
        $http_bot_mess =  $this->http::post(self::url . $this->bot . '/sendMessage',
            [
                'chat_id' => $chat_id,
                'text' => '<i> -' . $message . '- </i>',
                'parse_mode' => 'html',
                'reply_markup' => $button
            ]);

        return $http_bot_mess;
    }

    function resLastWeek($chat_id, $message)
    {
        $arrs_month = [];
        $mutable = Carbon::now();

        foreach (Category::all() as $k => $cat) {
            //перебираем категории - категории + 2 строки
            if (empty($arrs_month[0])) {

                $sum = Result::where('chat_id', null)
                    ->whereBetween('created_at', [$mutable->add(-7, 'day'), Carbon::now()])
                    ->sum('coast');
                $arrs_month[0] = ' Всего : ' . $sum;
            }

            $sum = Result::where('chat_id', null)
                ->whereBetween('created_at', [$mutable->add(-7, 'day'), Carbon::now()])
                ->where('category_id', $cat->id)
                ->sum('coast');
            $arrs_month[$k + 1] = $cat->title . ': ' . $sum;
        }

        return $this->http::post(self::url . $this->bot . '/sendMessage',
            [
                'chat_id' => $chat_id,
                'text' => (string)view('telegram.last_week',
                    compact('arrs_month')),
                'parse_mode' => 'html',
            ]);

    }

    function resYestMonth($chat_id, $message)
    {
        $fst = Message::where('chat_id', null)->latest()->first()->created_at->year;
        $latest_month = Message::where('chat_id', null)->latest()->first()->created_at->month;
        if ($latest_month === 1) {
            $fst -= $fst;
            $latest_month = 12;
        } else {
            $latest_month -= 1;
        }
        $month = $this->months[$latest_month];
        $arrs_month = [];

        foreach (Category::all() as $k => $cat) {
            //перебираем категории - категории + 2 строки
            if (empty($arrs_month[0])) {

                $sum = Result::where('chat_id', null)->whereYear('created_at', $fst)
                    ->whereMonth('created_at', $latest_month)
                    //->whereBetween('created_at', [Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])
                    ->sum('coast');
                $arrs_month[0] = ' Всего : ' . $sum;
            }

            $sum = Result::where('chat_id', null)->whereYear('created_at', $fst)
                ->whereMonth('created_at', $latest_month)
                // ->whereBetween('created_at', [Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])
                ->where('category_id', $cat->id)
                ->sum('coast');
            $arrs_month[$k + 1] = $cat->title . ': ' . $sum;
        }

        return $this->http::post(self::url . $this->bot . '/sendMessage',
            [
                'chat_id' => $chat_id,
                'text' => (string)view('telegram.last_month',
                    compact('fst', 'arrs_month', 'month')),
                'parse_mode' => 'html',
            ]);
    }

    function resLastMonth($chat_id, $message)
    {
        $fst = Message::where('chat_id', null)->latest()->first()->created_at->year;
        $latest_month = Message::where('chat_id', null)->latest()->first()->created_at->month;
        $month = $this->months[$latest_month];
        $arrs_month = [];

        foreach (Category::all() as $k => $cat) {
            //перебираем категории - категории + 2 строки
            if (empty($arrs_month[0])) {

                $sum = Result::where('chat_id', null)
                    ->whereYear('created_at', $fst)
                    ->whereMonth('created_at', $latest_month)
                    ->sum('coast');
                $arrs_month[0] = ' Всего : ' . $sum;
            }

            $sum = Result::where('chat_id', null)
                ->whereYear('created_at', $fst)
                ->whereMonth('created_at', $latest_month)
                ->where('category_id', $cat->id)
                ->sum('coast');
            $arrs_month[$k + 1] = $cat->title . ': ' . $sum;
        }

        return $this->http::post(self::url . $this->bot . '/sendMessage',
            [
                'chat_id' => $chat_id,
                'text' => (string)view('telegram.last_month', compact('fst', 'arrs_month', 'month')),
                'parse_mode' => 'html',
            ]);
    }

    function resLastYear($chat_id, $message)
    {
        $fst = Message::where('chat_id', null)->latest()->first()->created_at->year;
        $arrs_year = [];

        foreach ($this->months as $k => $mon) {
            if (empty($arrs_year[0])) {
                $sum = Result::where('chat_id', null)->whereYear('created_at', $fst)->sum('coast');
                $arrs_year[0] = "Всего: " . $sum;
            }
            $sum = Result::where('chat_id', null)->whereYear('created_at', $fst)
                ->whereMonth('created_at', $k)->sum('coast');
            $arrs_year[$k + 1] = $mon . ': ' . $sum;
        }

        return $this->http::post(self::url . $this->bot . '/sendMessage',
            [
                'chat_id' => $chat_id,
                'text' => (string)view('telegram.last_year', compact('fst', 'arrs_year')),
                'parse_mode' => 'html',
            ]);
    }

    function deleteMessage($chat_id, $message_id)
    {

        return $this->http::post(self::url . $this->bot . '/deleteMessage',
            [
                'chat_id' => $chat_id,
                'message_id' => $message_id
            ]);
    }

    function copyMessage($chat_id, $message_id)
    {

        $http = $this->http::post(self::url . $this->bot . '/copyMessage',
            [
                'chat_id' => $chat_id,
                'from_chat_id' => $chat_id,
                'message_id' => $message_id
            ]);

        if ($http->json('ok')) {
            $new_message_id = $http->json('result.message_id');
            $http = $this->deleteMessage($chat_id, $new_message_id);
        }else{
            $this->sendMessage($chat_id, 'Сообщение -' . $message_id . ' не найдено');
        }

        return $http;

    }
}
