<?php

namespace App\Http\Controllers;

use App\Models\Number;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AvitoController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        dump(113);
        $apiURL = 'https://www.avito.ru/all/avtomobili';
        $headers = [
     //       ':authority' => 'www.avito.ru',
            'Connection' => 'keep-alive',
      //      ':method' => 'GET',
    //        ':path' => '/',
    //        ':scheme' => 'https',
            'accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
            'accept-encoding' => 'gzip, deflate, br',
            'accept-language' => 'ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7',
            'cookie' => 'gMltIuegZN2COuSe=EOFGWsm50bhh17prLqaIgdir1V0kgrvN; u=2xsxxkq9.8qrtyl.18x6aqcq68g00; buyer_laas_location=621540; luri=all; buyer_location_id=621540; _gcl_au=1.1.306040031.1678648850; tmr_lvid=ef4216fd031c7c07024d9d54b17c32cc; tmr_lvidTS=1678648850301; _ga=GA1.1.27322492.1678648850; yexp=; _ym_uid=167864885172713640; _ym_d=1678648851; adrdel=1; adrcid=AgqcSS6wbWKIyocl5FW94HA; _ym_isad=2; uxs_uid=0075baf0-c10b-11ed-be67-735b8d1e4623; f=5.32e32548b6f3e9784b5abdd419952845a68643d4d8df96e9a68643d4d8df96e9a68643d4d8df96e9a68643d4d8df96e94f9572e6986d0c624f9572e6986d0c624f9572e6986d0c62ba029cd346349f36c1e8912fd5a48d02c1e8912fd5a48d0246b8ae4e81acb9fa143114829cf33ca746b8ae4e81acb9fa46b8ae4e81acb9fa143114829cf33ca7fbcd99d4b9f4cbdabcc8809df8ce07f640e3fb81381f359178ba5f931b08c66a59b49948619279110df103df0c26013a2ebf3cb6fd35a0acf722fe85c94f7d0c0df103df0c26013a7b0d53c7afc06d0bba0ac8037e2b74f92da10fb74cac1eab71e7cb57bbcb8e0f71e7cb57bbcb8e0f2da10fb74cac1eab0df103df0c26013a037e1fbb3ea05095de87ad3b397f946b4c41e97fe93686add2bdfb33ba79f0e5b7399555adb8b5e102c730c0109b9fbbc60ec9d2f66a8631c9fbdd7f5877c6d729aa4cecca288d6b91562fe38b2d2d258db57d0f7c7638d40df103df0c26013a0df103df0c26013aafbc9dcfc006bed9273639967bbf9c84852c0d1ecf16c7b33de19da9ed218fe23de19da9ed218fe2d6fdecb021a45a31b3d22f8710f7c4ed78a492ecab7d2b7f; ft="9eh0upBBMT5JhRxN+M5R/1KqfKulK4Pvsyo6+P6tH3Qmno1omuM4BeoxvWxRiy3FteMtSqJGJ3ctX2VGinfFq+B33USu4TBa865eT99vBCyRwy6/zSR+7cFlItaXr4f/2RwEdEMekw250GIjNZ1bvXMPdskKjTwPXfJoNq0d6dsPwmWKrkgDZnoPVw6BUl8Y"; sx=H4sIAAAAAAAC/1TMS3KDMAwA0LtonYVlY8niNvIviQcKDExxy3D3rrrIBd4Fhp0LKZDaGpNRl7T6hFyVo2aHCOMF3zBC28u0vqZfu71xbweuZ2/P/jUccV10U3hAgRGJAzsfiO8HEBGlzFSFxNNAUjgWJ5m9SYmz/MuzqFt+Gsve8TnNPZ7mTS8sZFk2+pTtIPf9FwAA//8fF6w1tQAAAA==; abp=0; _ga_M29JC28873=GS1.1.1678648850.1.1.1678649468.59.0.0; cto_bundle=hvxchV9QaEglMkJtdGFXVTk3SzhCc2lWbnhiMlR1aENXWHRKSzU1TWFVYUZmNDNFODR1MWR6Q0JuOGtzZ1RkT1klMkIlMkJpJTJCWFJkRUZwY0dzZUc1ZzZWZG1WOFAyNXNpbjJ6b0ZtUE90QXRjVW9PRXFuYVJmJTJGSzdORzYxV1NNaTVwdHJiTVduUFc; _buzz_fpc=JTdCJTIycGF0aCUyMiUzQSUyMiUyRiUyMiUyQyUyMmRvbWFpbiUyMiUzQSUyMi53d3cuYXZpdG8ucnUlMjIlMkMlMjJleHBpcmVzJTIyJTNBJTIyVHVlJTJDJTIwMTIlMjBNYXIlMjAyMDI0JTIwMTklM0EzMSUzQTA5JTIwR01UJTIyJTJDJTIyU2FtZVNpdGUlMjIlM0ElMjJMYXglMjIlMkMlMjJ2YWx1ZSUyMiUzQSUyMiU3QiU1QyUyMnZhbHVlJTVDJTIyJTNBJTVDJTIyOTE5ZmQ2ZWI3ZGU4NWZmNTQwMmE4NjY2Y2Q4ZDFhNjMlNUMlMjIlMkMlNUMlMjJmcGpzRm9ybWF0JTVDJTIyJTNBdHJ1ZSU3RCUyMiU3RA==; tmr_detect=0|1678649470920',
            'dnt' => 1,
            'if-none-match' => 1,
            'cache-control' => 'max-age=0',
            'referer' => 'https://www.google.com/',
            'sec-ch-ua' => 'Google Chrome";v="111", "Not(A:Brand";v="8", "Chromium";v="111',
            'sec-ch-ua-platform' => 'Windows',
            'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36',
        ];
//        $client = new \GuzzleHttp\Client(['headers' => $headers, 'cookies' => true]);
//        dump($client);
//        $response = $client->request('GET', $apiURL);
//        dd($response);
        //  $url = 'data:image/png;base64,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';
    //    $url1 = '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';
//        $http =  Http::get('https://www.avito.ru/');
        $http = Http::withHeaders([
//            ':authority' => 'www.avito.ru',
            'Connection' => 'keep-alive',
//            ':method' => 'GET',
//            ':path' => '/',
//            ':scheme' => 'https',
            'accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
            'accept-encoding' => 'gzip, deflate, br',
            'accept-language' => 'ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7',
            'cookie' => 'gMltIuegZN2COuSe=EOFGWsm50bhh17prLqaIgdir1V0kgrvN; u=2xsxxkq9.8qrtyl.18x6aqcq68g00; buyer_laas_location=621540; luri=all; buyer_location_id=621540; _gcl_au=1.1.306040031.1678648850; tmr_lvid=ef4216fd031c7c07024d9d54b17c32cc; tmr_lvidTS=1678648850301; _ga=GA1.1.27322492.1678648850; yexp=; _ym_uid=167864885172713640; _ym_d=1678648851; adrdel=1; adrcid=AgqcSS6wbWKIyocl5FW94HA; _ym_isad=2; uxs_uid=0075baf0-c10b-11ed-be67-735b8d1e4623; f=5.32e32548b6f3e9784b5abdd419952845a68643d4d8df96e9a68643d4d8df96e9a68643d4d8df96e9a68643d4d8df96e94f9572e6986d0c624f9572e6986d0c624f9572e6986d0c62ba029cd346349f36c1e8912fd5a48d02c1e8912fd5a48d0246b8ae4e81acb9fa143114829cf33ca746b8ae4e81acb9fa46b8ae4e81acb9fa143114829cf33ca7fbcd99d4b9f4cbdabcc8809df8ce07f640e3fb81381f359178ba5f931b08c66a59b49948619279110df103df0c26013a2ebf3cb6fd35a0acf722fe85c94f7d0c0df103df0c26013a7b0d53c7afc06d0bba0ac8037e2b74f92da10fb74cac1eab71e7cb57bbcb8e0f71e7cb57bbcb8e0f2da10fb74cac1eab0df103df0c26013a037e1fbb3ea05095de87ad3b397f946b4c41e97fe93686add2bdfb33ba79f0e5b7399555adb8b5e102c730c0109b9fbbc60ec9d2f66a8631c9fbdd7f5877c6d729aa4cecca288d6b91562fe38b2d2d258db57d0f7c7638d40df103df0c26013a0df103df0c26013aafbc9dcfc006bed9273639967bbf9c84852c0d1ecf16c7b33de19da9ed218fe23de19da9ed218fe2d6fdecb021a45a31b3d22f8710f7c4ed78a492ecab7d2b7f; ft="9eh0upBBMT5JhRxN+M5R/1KqfKulK4Pvsyo6+P6tH3Qmno1omuM4BeoxvWxRiy3FteMtSqJGJ3ctX2VGinfFq+B33USu4TBa865eT99vBCyRwy6/zSR+7cFlItaXr4f/2RwEdEMekw250GIjNZ1bvXMPdskKjTwPXfJoNq0d6dsPwmWKrkgDZnoPVw6BUl8Y"; sx=H4sIAAAAAAAC/1TMS3KDMAwA0LtonYVlY8niNvIviQcKDExxy3D3rrrIBd4Fhp0LKZDaGpNRl7T6hFyVo2aHCOMF3zBC28u0vqZfu71xbweuZ2/P/jUccV10U3hAgRGJAzsfiO8HEBGlzFSFxNNAUjgWJ5m9SYmz/MuzqFt+Gsve8TnNPZ7mTS8sZFk2+pTtIPf9FwAA//8fF6w1tQAAAA==; abp=0; _ga_M29JC28873=GS1.1.1678648850.1.1.1678649468.59.0.0; cto_bundle=hvxchV9QaEglMkJtdGFXVTk3SzhCc2lWbnhiMlR1aENXWHRKSzU1TWFVYUZmNDNFODR1MWR6Q0JuOGtzZ1RkT1klMkIlMkJpJTJCWFJkRUZwY0dzZUc1ZzZWZG1WOFAyNXNpbjJ6b0ZtUE90QXRjVW9PRXFuYVJmJTJGSzdORzYxV1NNaTVwdHJiTVduUFc; _buzz_fpc=JTdCJTIycGF0aCUyMiUzQSUyMiUyRiUyMiUyQyUyMmRvbWFpbiUyMiUzQSUyMi53d3cuYXZpdG8ucnUlMjIlMkMlMjJleHBpcmVzJTIyJTNBJTIyVHVlJTJDJTIwMTIlMjBNYXIlMjAyMDI0JTIwMTklM0EzMSUzQTA5JTIwR01UJTIyJTJDJTIyU2FtZVNpdGUlMjIlM0ElMjJMYXglMjIlMkMlMjJ2YWx1ZSUyMiUzQSUyMiU3QiU1QyUyMnZhbHVlJTVDJTIyJTNBJTVDJTIyOTE5ZmQ2ZWI3ZGU4NWZmNTQwMmE4NjY2Y2Q4ZDFhNjMlNUMlMjIlMkMlNUMlMjJmcGpzRm9ybWF0JTVDJTIyJTNBdHJ1ZSU3RCUyMiU3RA==; tmr_detect=0|1678649470920',
            'dnt' => 1,
            'if-none-match' => 1,
            'cache-control' => 'max-age=0',
           'referer' => 'https://www.google.com/',
            'sec-ch-ua' => 'Google Chrome";v="111", "Not(A:Brand";v="8", "Chromium";v="111',
            'sec-ch-ua-platform' => 'Windows',
           'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36',
        ])->get('https://www.avito.ru/all/avtomobili');
        dump(111);
        return $http->body();
        dd($http);

        $st = Storage::disk('public')->put('example.png', base64_decode($url1));
        dd($st);

        $img_start = Storage::disk('public')->get('capcha/a89587886327.png');
        dump(asset('public/capcha/a89587886327.png'));
        // dump($img_start);
        $height = Image::make($img_start)->height();
        $width = Image::make($img_start)->width();
        // dump($height);
        //  dump($width);
        //  $data = Image::make($img_start)->getCore();//++
        $img = Image::make($img_start);//++

// pick a color at position as array
        $arraycolor = $img->pickColor(1, 1);
        $arraycolor1 = $img->pickColor(172, 25);

// pick a color at position as integer
        $intcolor = $img->pickColor(1, 1, 'int');
        $intcolor1 = $img->pickColor(172, 25, 'int');

// pick a color at position and format it as hex string
        $hexcolor = $img->pickColor(1, 1, 'hex');
        //  $data1 = Image::make($img)->embossImage(0, 1);
        dump($arraycolor);
        dump($arraycolor1[3]);
        dump($intcolor);
        dump($intcolor1);
        dump($hexcolor);
        // dd($data1);
        $background = null;
        $binary = [];
        $first_x = $width;
        $first_y = 0;
        $breack_x = [];
        $breack_y = [];
        $array_res = [];
        $array_res[0] = 0;
        $key = 0;
        $sum = 0;
//        for ($i = 0; $i < $height; $i++){
//            for ($j = 0; $j < $width; $j++) {
//
//               // $r = $img->pickColor($j, $i, 'int');
//                $r = $img->pickColor($j, $i);
//                //  dump($j);
//                //  dump($i);
//                 // dump($r[3]);
//                // если цвет пикселя не равен фоновому заполняем матрицу единицей
//                $binary[$i][$j] = ($r[3] === 1) ? 0 : 1;
//              //  $first_x = ($binary[$i][$j] && $first_x > $j) ? $j : $first_x;
//
//            }
//
//                $breack_x[$i] = array_sum($binary[$i]);
//
//    }

        for ($j = 0; $j < $width; $j++) {
            for ($i = 0; $i < $height; $i++) {

                $r = $img->pickColor($j, $i, 'int');

                //  dump($j);
                //  dump($i);
                //  dump($r);
                // если цвет пикселя не равен фоновому заполняем матрицу единицей
                $binary_2[$j][$i] = ($r != $background) ? 0 : 1;
                if ($i < ($height / 2)) {
                    $binary_3[$j][$i] = ($r != $background) ? 0 : 1;
                }


                // $first_x = ($binary[$i][$j] && $first_x > $j) ? $j : $first_x;

            }
            if (array_sum($binary_2[$j]) != 0) {
                //  dd(array_sum($binary_2[$j]));
                $array_res[$key][0] = $sum;
                $array_res[$key][1] = $sum2;
                $sum += array_sum($binary_2[$j]);
                $sum2 += array_sum($binary_3[$j]);
                $array_res[$key][0] += $sum;
                $array_res[$key][1] += $sum2;
                $array_res[$key][2] = $key;
                $array_res[$key][3] = 0;
                // dump($array_res);
            } else {
                if (isset($array_res[$key][3]) && $array_res[$key][3] === 0) {
                    $array_res[$key][3] = $j;
                    $array_res[$key][4] = $j - $key;
                }
                $sum = 0;
                $sum2 = 0;
                $key = $j;
            }

            // $breack_y[$j] = array_sum($binary_2[$j]);

        }


        //  dump($first_x);
        // dump($breack_x);
        dump($array_res);
        //  ksort($array_res);
        //  dump($array_res);
        //  dump($breack_y);

        // dd($binary);
//        $img_new = @imagecreatefrompng(asset('public/capcha/1.png'));
//        dump($img_new);
//        $height = imagesx($img_new);
//        $width = imagesy($img_new);
//        dump($height);
//        dump($width);
        return 2222;
    }

    public function create()
    {
        return view('avito.parsenumber.create');
    }

    public function storeimgphone(Request $request)
    {
        if ($request->input('file') && $request->file('file')->getClientOriginalExtension() == 'txt') {
            return 404;

        }
        //  $st = Storage::disk('local')->put('example.txt', json_encode($string, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $path = $request->file('file')->storeAs(
            'avito',
            $request->file('file')->getClientOriginalName(),
            'public'
        );
        //  dd($path);
        //получаем файл
        $file_upload = Storage::disk('public')->get($path);
        $height = Image::make($file_upload)->height();
        $width = Image::make($file_upload)->width();
        $background = null;
        $binary = [];
        $array_res = [];
        $array_res[0] = 0;
        $key = 0;
        $sum = 0;
        $img = Image::make($file_upload);


        for ($j = 0; $j < $width; $j++) {
            for ($i = 0; $i < $height; $i++) {

                $r = $img->pickColor($j, $i, 'int');

                //  dump($j);
                //  dump($i);
                //  dump($r);
                // если цвет пикселя не равен фоновому заполняем матрицу единицей
                $binary_2[$j][$i] = ($r != $background) ? 0 : 1;
                if ($i < ($height / 2)) {
                    $binary_3[$j][$i] = ($r != $background) ? 0 : 1;
                }


                // $first_x = ($binary[$i][$j] && $first_x > $j) ? $j : $first_x;

            }
            if (array_sum($binary_2[$j]) != 0) {
                //  dd(array_sum($binary_2[$j]));
                $array_res[$key][0] = $sum;
                $array_res[$key][1] = $sum2;
                $sum += array_sum($binary_2[$j]);
                $sum2 += array_sum($binary_3[$j]);
                $array_res[$key][0] += $sum;
                $array_res[$key][1] += $sum2;
                $array_res[$key][2] = $key;
                $array_res[$key][3] = 0;
                // dump($array_res);
            } else {
                if (isset($array_res[$key][3]) && $array_res[$key][3] === 0) {
                    $array_res[$key][3] = $j;
                    $array_res[$key][4] = $j - $key;
                }
                $sum = 0;
                $sum2 = 0;
                $key = $j;
            }


            // $breack_y[$j] = array_sum($binary_2[$j]);

        }
        $key = 0;
        $res_array = [];
        $cnt = 0;
        foreach ($array_res as $value) {
            if ($cnt === 0 || $cnt === 8 || $cnt === 11) {
                $cnt++;
                continue;
            }
            $number = Number::where('sum_parse_all', $value[0])->where('sum_parse_half', $value[1])->first();
            if ($number) {
                $res_array[] = $number->number;
            } else {
                $res_array[] = '?';
            }
            $cnt++;
        }
        $result_phone = implode(' - ', $res_array);
        //  dump($res_array);
        //  dd($array_res);


        return view('avito.parsenumber.create', compact('path', 'result_phone'));
    }

    public function addimgphone(Request $request)
    {
        $res = $request->all();
        $file_upload = Storage::disk('public')->get($res['file_path']);
        $height = Image::make($file_upload)->height();
        $width = Image::make($file_upload)->width();

        // dump($file_upload);
        // dump($height);
        // dump($width);

        $background = null;
        $binary = [];
        $array_res = [];
        $array_res[0] = 0;
        $key = 0;
        $sum = 0;

        $img = Image::make($file_upload);

        for ($j = 0; $j < $width; $j++) {
            for ($i = 0; $i < $height; $i++) {

                $r = $img->pickColor($j, $i, 'int');

                //  dump($j);
                //  dump($i);
                //  dump($r);
                // если цвет пикселя не равен фоновому заполняем матрицу единицей
                $binary_2[$j][$i] = ($r != $background) ? 0 : 1;
                if ($i < ($height / 2)) {
                    $binary_3[$j][$i] = ($r != $background) ? 0 : 1;
                }


                // $first_x = ($binary[$i][$j] && $first_x > $j) ? $j : $first_x;

            }
            if (array_sum($binary_2[$j]) != 0) {
                //  dd(array_sum($binary_2[$j]));
                $array_res[$key][0] = $sum;
                $array_res[$key][1] = $sum2;
                $sum += array_sum($binary_2[$j]);
                $sum2 += array_sum($binary_3[$j]);
                $array_res[$key][0] += $sum;
                $array_res[$key][1] += $sum2;
                $array_res[$key][2] = $key;
                $array_res[$key][3] = 0;
                // dump($array_res);
            } else {
                if (isset($array_res[$key][3]) && $array_res[$key][3] === 0) {
                    $array_res[$key][3] = $j;
                    $array_res[$key][4] = $j - $key;
                }
                $sum = 0;
                $sum2 = 0;
                $key = $j;
            }

            // $breack_y[$j] = array_sum($binary_2[$j]);

        }

        $cnt = 0;
        $num_key = 0;
        foreach ($array_res as $k => $val) {

            if ($cnt === 0 || $cnt === 8 || $cnt === 11) {
                $cnt++;
                continue;
            }
            $number = Number::create([
                'number' => $res['number'][$num_key],
                'section' => $k,
                'sum_parse_all' => $val[0],
                'sum_parse_half' => $val[1],
            ]);
            $num_key++;
            // dump($val);
            $cnt++;
        }


        //  dump($first_x);
        // dump($breack_x);
        // dump($array_res);

        //  dd($res);
        return redirect()->route('avito.create');
    }
}
