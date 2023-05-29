<?php

namespace App\Http\Controllers\Vue\Category;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryResourse;
use App\Http\Resources\Category\ResultResourse;
use App\Http\Resources\Category\TagResourse;
use App\Http\Resources\Message\MessageResource;
use App\Models\Category;
use App\Models\Message;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $categories =  Category::all();
      //  return json_encode($messages);
        return CategoryResourse::collection($categories);
    }
}
