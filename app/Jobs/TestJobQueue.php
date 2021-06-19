<?php

namespace App\Jobs;

use App\Exceptions\BusinessException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Wujunze\DingTalkException\DingTalkExceptionHelper;

class TestJobQueue implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        try {
            throw new BusinessException('测试 Queue', 1);
        } catch (\Exception $e) {
            DingTalkExceptionHelper::notify($e);
        }
    }
}
