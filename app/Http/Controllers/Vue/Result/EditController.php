<?php

namespace App\Http\Controllers\Vue\Result;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Message\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;

class EditController extends BaseController
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
