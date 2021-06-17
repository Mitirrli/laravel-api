<?php

namespace App\Http\Controllers;

use App\Http\Requests\DemoRequest;
use App\Models\Demo;

class Demos extends Controller
{
    protected Demo $demo;

    public function __construct(Demo $demo)
    {
        $this->demo = $demo;
    }

    public function save(DemoRequest $request): void
    {
        $demo = $this->demo::create($request->validated());
    }

    public function list()
    {
        return \response()->output(data: $this->demo->first());
    }
}
