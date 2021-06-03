<?php

declare(strict_types=1);

namespace App\Exceptions;

class BusinessException extends \Exception
{
    public function render()
    {
        return \response()->json([
            'code' => $this->getCode(),
            'message' => $this->getMessage(),
        ]);
    }
}
