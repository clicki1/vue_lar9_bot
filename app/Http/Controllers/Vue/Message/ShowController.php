<?php

namespace App\Http\Controllers\Vue\Message;

use App\Http\Controllers\Controller;
use App\Http\Resources\Message\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Message $message)
    {
        return new MessageResource($message);
    }
}
