<?php

namespace Tests\Feature;

use Tests\TestCase;

class BasicTest extends TestCase
{
    public function test_undefine_route()
    {
        $response = $this->get('/');

        $response->assertStatus(404);
    }

    public function test_business_exception()
    {
        // throw new BusinessException('测试一下功能', 200);
    }

    public function test_system_exception()
    {
    }
}
