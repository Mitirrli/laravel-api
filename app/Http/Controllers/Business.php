<?php

namespace App\Http\Controllers;

use App\Exceptions\BusinessException;

class Business extends Controller
{
    public function __invoke()
    {
        throw new BusinessException('测试一下', 200);
    }
}
