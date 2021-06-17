<?php

namespace App\Http\Controllers;

use App\Exceptions\SystemException;

class System extends Controller
{
    public function __invoke(): void
    {
        throw new SystemException('系统异常', 500);
    }
}
