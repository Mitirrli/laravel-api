<?php

namespace App\Http\Controllers\Test;

use App\Exceptions\SystemException;
use App\Http\Controllers\Controller;
use App\Exceptions\BusinessException;

class ExceptionController extends Controller
{
    public function business()
    {
        throw new BusinessException('测试一下', 200);
    }

    public function system()
    {
        throw new SystemException('系统异常', 500);
    }
}
