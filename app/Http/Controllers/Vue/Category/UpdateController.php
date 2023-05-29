<?php

namespace App\Http\Controllers\Vue\Category;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Vue\Category\UpdateRequest;
use App\Models\Category;

class UpdateController extends BaseController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(UpdateRequest $request, Category $category)
    {

        $data = $request->validated();
        $this->service->updateCategory($data, $category);

        return response([]);
    }
}
