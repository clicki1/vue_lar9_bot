<?php

namespace App\Http\Controllers\Vue\Tag;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Vue\Tag\CreateRequest;
use App\Http\Requests\Vue\Category\StoreRequest;

class StoreController extends BaseController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(CreateRequest $request)
    {
       // dd($request);
        $data = $request->validated();
        $tag = $this->service->storeTag($data);


       return response([]);
    }
}
