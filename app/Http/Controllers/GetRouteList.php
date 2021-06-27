<?php

namespace App\Http\Controllers;

use Artisan;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class GetRouteList extends Controller
{
    /**
     * 使用命名空间作为路由的id 后续开发不能修改代码路径.
     *
     * @return void
     */
    public function __invoke(): JsonResponse
    {
        Artisan::call('route:list --name="backendAPI " --columns=name,action --json');

        //获取满足条件的路由
        $result = \json_decode(Str::of(Artisan::output())->replace('backendAPI ', ''), true);

        $temp = [];
        \array_walk($result, function (&$value) use (&$temp): void {
            $temp[\mb_substr($name = $value['name'], 0, $pos = \mb_strpos($name, '.'))][] = [
                'name' => $name = \mb_substr($value['name'], $pos + 1),
                'id' => \md5(Str::replace('\\', '', $value['action'])),
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
