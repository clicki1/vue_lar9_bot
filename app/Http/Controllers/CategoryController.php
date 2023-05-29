<?php

namespace App\Http\Controllers;

use App\Http\Filters\CategoryFilter;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\Vue\Category\FilterRequest;
use App\Models\Category;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FilterRequest $request)
    {
        $data = $request->validated();

        $filter = app()->make(CategoryFilter::class, ['queryParams'=> array_filter($data)]);
        $categories = Category::filter($filter)->paginate(10);
//
//        $query = Category::query();
//
//        $page = $data['page'] ?? 1;
//        $perPage = $data['per_page'] ?? 7;
//
//        if (isset($data['id'])) {
//            $query->where('id', $data['id']);
//        }
//        if (isset($data['title'])) {
//            $query->where('title','like', "%{$data['title']}%");
//        }
//
//        $categories = $query->paginate($perPage, ['*'], 'page', $page);

      //  return CategoryResourse::collection($categories);


       return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {

        $data = $request->validated();
       //  dd($data);

        $cat = $this->service->storeCategory($data);

      //  return new CategoryResourse($cat);

        return redirect()->route('categories.index')->with('info', 'Добавлена новая категория');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $categories = Category::where('id', $category->id)->paginate(1);

        return view('categories.index', compact('categories', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $data = $request->validated();

        $this->service->updateCategory($data, $category);

      //  return new CategoryResourse($category);

        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
            $tags = $category->tags()->forceDelete();
            $category->forceDelete();
        return redirect()->route('categories.index');
    }
}
