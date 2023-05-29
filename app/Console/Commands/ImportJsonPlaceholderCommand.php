<?php

namespace App\Console\Commands;

use App\Components\ImportDataClient;
use Illuminate\Console\Command;



class ImportJsonPlaceholderCommand extends Command
{
    protected $signature = 'import:jsonplaceholder';

    protected $description = 'Get data from jsonplaceholder site';

    public function handle()
    {
        $import = new ImportDataClient();
        $response = $import->client->request('GET', 'https://jsonplaceholder.typicode.com/posts');
        dd(json_decode($response->getBody()->getContents()));

//        $import = new ImportDataClient();
//        $request = $import->client->get('https://jsonplaceholder.typicode.com/posts');
//        $response = $request->getBody();
//
//        dd($response);
    }
}
