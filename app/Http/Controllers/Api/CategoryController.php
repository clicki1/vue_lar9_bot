<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CategoryController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $data = $request->all();
        // dd($data);

        foreach ($data as $dt) {


            try {
                DB::beginTransaction();
                foreach ($dt as $k => $v) {
                    $category['title'] = $k;

                    $cat = Category::firstOrCreate([
                        'title' => $k,
                    ], $category);

                    $tag_arr['category_id'] = $cat->id;
                    $tag_arr['title'] = $v;

                    $tag = Tag::firstOrCreate([
                        'title' => $v,
                    ], $tag_arr);
                }
                DB::commit();
            } catch (\Exception $exception) {

                DB::rollBack();
                return $exception->getMessage();
            }

        }
        return 'ok';
    }


}
