<?php

namespace App\Http\Controllers\Vue\Result;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Result\ResultResourse;
use App\Models\Result;

class ShowController extends BaseController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Result $result)
    {
        return new ResultResourse($result);
    }
}
