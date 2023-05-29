<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Message;
use App\Models\Result;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $all_data = $request->all();

        try {
            DB::beginTransaction();
            foreach ($all_data as $data) {

                unset($data['username']);

                $message = mb_strtolower(($data['message'] ? $data['message'] : $data['message']), 'utf-8');
                $k = preg_split("/(:|\.|,\s)/", $data['created_at']);
                $d = mktime($k[3], $k[4], $k[5], $k[1], $k[0], $k[2]);
                $car = Carbon::createFromTimestamp($d)->toDateTimeString();

                $new_arr = explode(" ", $message);
                $res_str = '';
                $num = '';
                $cat = null;

                foreach ($new_arr as $arr) {
                    !is_numeric($arr) ? $res_str .= " " . $arr : $num = $arr;

                    if (!$cat) {

                        $cat = Category::where('title', $arr)->first();

                        if(!$cat){
                            $tag = Tag::where('title', $arr)->first();

                            if ($tag && !$cat) {
                                $cat = $tag->category;
                            }
                        }

                    }
                }
                $res_str = trim($res_str);
                $data['created_at'] = $car;
                if(!$num || !$data['message']){
                    dd($data);
                }
                $mess = Message::firstOrCreate([
                    'message' => $data['message'],
                    'created_at' => $data['created_at']
                ], $data);


                $res = Result::where('message_id', $mess->id)->first();

                if (!$res) {

                    $res = new Result();
                    $res->coast = $num;
                    $res->message_id = $mess->id;
                    $res->created_at = $data['created_at'];
                    if ($cat) {
                        $res->category_id = $cat->id;
                    }

                    $res->save();
                }

            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return $exception->getMessage();
        }
        return 'ok';


    }
}
