<?php

namespace App\Http\Controllers\Vue\Result;

use App\Http\Controllers\BaseController;
use App\Http\Requests\ResultRequest;
use App\Http\Requests\Vue\Result\UpdateRequest;
use App\Models\Category;
use App\Models\Result;

class UpdateController extends BaseController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ResultRequest $request, Result $result)
    {
        $result->category_id = $request->input('category_id');
        $result->save();

        return response([]);
    }
}
