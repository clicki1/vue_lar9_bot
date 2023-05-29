<?php

namespace App\Http\Controllers\Vue\Tag;

use App\Http\Controllers\BaseController;
use App\Http\Filters\TagFilter;
use App\Http\Requests\Vue\Tag\FilterRequest;
use App\Http\Resources\Tag\TagResourse;
use App\Models\Tag;

class IndexController extends BaseController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(FilterRequest $request)
    {
        $data = $request->validated();
        $filter = app()->make(TagFilter::class, ['queryParams'=> array_filter($data)]);
       // $tags = Tag::filter($filter)->orderBy('id', 'desc')->paginate(30);
        $tags = Tag::filter($filter)->orderBy('id')->get();
        return TagResourse::collection($tags);
    }
}
