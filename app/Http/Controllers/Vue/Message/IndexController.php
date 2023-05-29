<?php

namespace App\Http\Controllers\Vue\Message;

use App\Http\Controllers\Controller;
use App\Http\Resources\Message\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $chat_id = $request->session()->get('chat_id');
        $limit = 10;
        if($request->input('limit')){
            $limit = $request->input('limit');
        }
        $messages = Message::orderByDesc('id')
            ->where('chat_id', $chat_id)
            ->take($limit)
            ->get();
        // return json_encode($messages);
        return MessageResource::collection($messages);
    }
}
