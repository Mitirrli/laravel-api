<?php

namespace Tests\Feature;

use Tests\TestCase;

class BasicTest extends TestCase
{
    public function test_undefine_route()
    {
        $response = $this->get('/');

        $response->assertStatus(404);
        $response->assertNotFound();
    }

    public function test_business_exception()
    {
        $response = $this->get('/test/business');

        $response->assertStatus(200);
        $response->assertJson(['code' => 200, 'message' => '测试一下']);
    }

    public function test_system_exception()
    {
        $response = $this->get('/test/system');

        $response->assertStatus(500);
    }

    public function testEtag()
    {
        $response = $this->get('/demo/list');

        $response->assertStatus(200);

        $response = $this->get('/demo/list', ['If-None-Match' => $response->headers->get('etag')]);

        $response->assertStatus(304);
    }
}
