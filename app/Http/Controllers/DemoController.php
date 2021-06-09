<?php

namespace App\Http\Controllers;

use App\Http\Requests\DemoRequest;
use App\Models\Demo;

class DemoController extends Controller
{
    protected Demo $demo;

    public function __construct(Demo $demo)
    {
        $this->demo = $demo;
    }

    public function save(DemoRequest $request)
    {
        $demo = $this->demo::create($request->validated());
    }

    public function list()
    {
        return $this->demo->first();
    }
}
