<?php

namespace App\Http\Controllers;

class Health extends Controller
{
    public function __invoke()
    {
        return \response()->json();
    }
}
