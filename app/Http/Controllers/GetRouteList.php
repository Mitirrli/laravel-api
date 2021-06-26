<?php

namespace App\Http\Controllers;

use Artisan;
use Illuminate\Support\Str;

class GetRouteList extends Controller
{
    public function __invoke()
    {
        Artisan::call('route:list --name="backendAPI " --columns=name,uri,method --json');

        //获取满足条件的路由
        $result = \json_decode(Str::of(Artisan::output())->replace('backendAPI ', ''), true);

        $temp = [];
        \array_walk($result, function (&$value) use (&$temp): void {
            $temp[\mb_substr($name = $value['name'], 0, $pos = \mb_strpos($name, '.'))][] = [
                'name' => \mb_substr($value['name'], $pos + 1),
                'uri' => $value['uri'],
                'method' => $value['method'],
            ];
        });

        //路由分组
        $group = [];
        \array_walk($temp, function ($value, $key) use (&$group): void {
            $group[] = ['key' => $key, 'value' => $value];
        });

        return \response()->json($group);
    }
}
