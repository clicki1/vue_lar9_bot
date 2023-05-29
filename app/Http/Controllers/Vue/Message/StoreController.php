<?php

namespace App\Http\Controllers\Vue\Message;

use App\Http\Controllers\BaseController;
use App\Http\Requests\MessageRequest;

class StoreController extends BaseController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(MessageRequest $request)
    {
      //  dd(222);
       // $chat_id = $request->session()->get('chat_id');
       // $data = $request->validated();
        $data = $request->validated();
        $mess = $this->service->storeMessageNew($data);

       return response([]);
    }
}
