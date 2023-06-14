<?php

namespace Tests;

class PingTest extends ApiTestCase
{
    public function testPing(): void
    {
        $response = $this->get('/api/ping', jsonDecodeBody: false);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['success' => true, 'code' => 200], $this->jsonDecodeBody($response));
    }
}
