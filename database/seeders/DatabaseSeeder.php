<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //start
        $test_preg = Storage::get('cat_tag_new.txt');
        $value = preg_replace('/ /', '', $test_preg);
        $arr_car_all = preg_split('/\\r\\n?|\\s\\n|\\n/', $value);
        $cat_tags_array = [];
        foreach ($arr_car_all as $k => $v) {
            if (!$v) continue;
            $v = trim($v);
            $arr_str = [];
            $arr_str = preg_split("/\\t/", $v);
            // dd($arr_str);
            $cat_tags_array[$k][$arr_str[0]] = $arr_str[1];

            $category = Category::firstOrCreate([
                'title' => key($arr_str[0]),
            ],[
                'title' => key($arr_str[0])
            ]);
            $tag = Tag::firstOrCreate([
                'title' => current($arr_str[0]),
            ], [
                'title' => key($arr_str[0]),
                'category_id' => $category->id,
            ]);

            // $cat_tags_array[][1] = $arr_str[1];
        }
//        foreach ($cat_tags_array as $k => $array_v){
//           // dump(key($array_v));
//          //  dump(current($array_v));
//            $category = Category::firstOrCreate([
//                'title' => key($array_v),
//            ],[
//                'title' => key($array_v)
//            ]);
//            $tag = Tag::firstOrCreate([
//                'title' => current($array_v),
//            ], [
//                'title' => key($array_v),
//                'category_id' => $category->id,
//            ]);
//        }

       // dd($cat_tags_array);
        echo 'Hello';
     //  Category::factory(5)->create();
      // Tag::factory(20)->create();
      //  dd($categories);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
