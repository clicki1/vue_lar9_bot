<?php

namespace App\Http\Controllers\Vue\Result;

use App\Http\Controllers\BaseController;
use App\Models\Category;

class DeleteController extends BaseController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Category $category)
    {
        $category->tags()->forceDelete();
        $category->forceDelete();

        return response([]);
    }
}
