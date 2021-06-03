<?php

declare(strict_types=1);

namespace App\Exceptions;

class SystemException extends \Exception
{
    public function render()
    {
        return \response('接口调用出问题了~', 500);
    }
}
