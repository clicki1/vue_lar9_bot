<?php

namespace App\Http\Controllers\Vue\Message;

use App\Http\Controllers\BaseController;
use App\Http\Requests\MessageRequest;
use App\Http\Requests\Vue\Message\UpdateRequest;
use App\Models\Message;

class UpdateController extends BaseController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(UpdateRequest $request, Message $message)
    {

        $data = $request->validated();

        $res = $this->service->updateMessageNewTg($data, $message);
        //$res = $this->service->updateMessageNew($data, $message);

        return response([]);
    }
}
