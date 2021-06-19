<?php

namespace App\Http\Controllers;

use App\Jobs\TestJobQueue;

class TestJob extends Controller
{
    public function __invoke(): void
    {
        $job = new TestJobQueue();

        $this->dispatch($job);
    }
}
