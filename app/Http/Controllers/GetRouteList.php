<?php

namespace App\Http\Controllers;

use Artisan;
use Illuminate\Support\Str;

class GetRouteList extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        Artisan::call('route:list --name="test." --columns=name,uri --json');

        return response()->json(json_decode(Str::of(Artisan::output())->replace('test.', ''), true));
    }
}
