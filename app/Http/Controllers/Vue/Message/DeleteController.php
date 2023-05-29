<?php

namespace App\Http\Controllers\Vue\Message;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class DeleteController extends BaseController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Message $message)
    {
        $message->results()->delete();
        $message->delete();

        return response([]);
    }
}
