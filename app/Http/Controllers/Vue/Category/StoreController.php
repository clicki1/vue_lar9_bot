<?php

namespace App\Http\Controllers\Vue\Category;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Vue\Category\StoreRequest;

class StoreController extends BaseController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(StoreRequest $request)
    {

      //  dd(333);

        $data = $request->validated();


        $message = $this->service->storeCategory($data);

       return response([]);
    }
}
