<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Services\Base\Telegram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiBotController extends BaseController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Telegram $telegram)
    {
       // Log::debug($request->all());
        $buttons = [
            'inline_keyboard' => [
                [
                    [
                        'text' => 'button1',
                        'callback_data' => 'button111',
                    ],
                    [
                        'text' => 'button2',
                        'callback_data' => '2',
                    ]
                ],
                [
                    [
                        'text' => 'button3',
                        'callback_data' => '3',
                    ],
                    [
                        'text' => 'button4',
                        'callback_data' => '4',
                    ],
                ],
            ]
        ];

        $buttons2 = [
            'resize_keyboard' => true,
            'one_time_keyboard' => false,
            'keyboard' => [
                [
                    [
                        'text' => 'button11',
                        'callback_data' => 'button111',
                    ],
                    [
                        'text' => 'button22',
                        'callback_data' => '2',
                    ]
                ],
                [
                    [
                        'text' => 'button33',
                        'callback_data' => '3',
                    ],
                    [
                        'text' => 'button44',
                        'callback_data' => '4',
                    ],
                ],
            ]
        ];

      //  $guzzleClient = new \GuzzleHttp\Client(['verify' => false]);

        $message = $request->input('message.text');


      //  return 1111;
     //   $telegram = new Telegram();
     //  $http =  $telegram->sendMessage(-815618907, $message);
     // $http =  $telegram->resLastYear(360336947, $message);
     //  $http =  $telegram->resLastMonth(360336947, $message);
     //  $http =  $telegram->resYestMonth(360336947, $message);
     //  $http =  $telegram->resLastWeek(360336947, $message);
     //  $http =  $telegram->editMessage(360336947, 'EDIT2', 316);
      // $http =  $telegram->deleteMessage(-815618907, 334);
      // $http =  $telegram->copyMessage(-815618907, 3363);
       $http =  $telegram->sendButton(-815618907, $message);
//            Http::post('https://api.telegram.org/bot5903822805:AAEqYIWvKrOI_p36GlrxS9RIhzrYnw2wGw4/sendMessage',
//            [
//                'chat_id' => 360336947,
//                'text' => '<i> -'.$data.'- </i>',
//                'parse_mode' => 'html',
//            ]);
return dd($http->json());

    }
}
