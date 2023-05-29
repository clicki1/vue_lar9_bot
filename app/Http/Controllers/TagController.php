<?php

namespace App\Http\Controllers;

use App\Http\Filters\TagFilter;
use App\Http\Requests\Tag\CreateRequest;
use App\Http\Requests\Tag\UpdateRequest;
use App\Http\Requests\Vue\Tag\FilterRequest;
use App\Models\Category;
use App\Models\Tag;

class TagController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FilterRequest $request)
    {
       // dd($request->input('category_id'));
        $data = $request->validated();
        $filter = app()->make(TagFilter::class, ['queryParams'=> array_filter($data)]);
        $tags = Tag::filter($filter)->paginate(10);
        $categories = Category::all();
        return view('tags.index', compact('tags', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('tags.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $data = $request->validated();
        $tag = $this->service->storeTag($data);
        return redirect()->route('tags.index')->with('info', 'Добавлен новый тэг - '.$tag->title);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        $categories = Category::all();

        return view('tags.create', compact('categories', 'tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Tag $tag)
    {
        $data = $request->validated();

        $tag = $this->service->updateTag($data, $tag);
        return redirect()->route('tags.index')->with('info', 'Изменен тэг - '.$tag->title);;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->forceDelete();
        return redirect()->route('tags.index');
    }
}
