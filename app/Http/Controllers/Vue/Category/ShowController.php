<?php

namespace App\Http\Controllers\Vue\Category;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Category\TagResourse;
use App\Models\Category;

class ShowController extends BaseController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Category $category)
    {
        return new TagResourse($category);
    }
}
