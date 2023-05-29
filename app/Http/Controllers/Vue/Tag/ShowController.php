<?php

namespace App\Http\Controllers\Vue\Tag;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Tag\TagResourse;
use App\Models\Tag;

class ShowController extends BaseController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Tag $tag)
    {

        return new TagResourse($tag);
    }
}
