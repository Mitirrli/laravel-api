<?php

namespace App\Http\Controllers;

use App\Http\Middleware\ApiAuth;
use App\Http\Requests\DemoRequest;
use App\Jobs\DemoTest;
use App\Models\Demo;
use Carbon\Carbon;

class Demos extends Controller
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
    return response()->output(data: $this->demo->first());
  }
}
