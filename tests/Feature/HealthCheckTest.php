<?php

namespace Tests\Feature;

use Tests\TestCase;

class HealthCheckTest extends TestCase
{
    public function test_health_check(): void
    {
        $response = $this->get('/api/status');
        
        $response->assertStatus(200)
            ->assertJsonFragment([
                'status' => 'ok',
                'message' => 'La API está funcionando correctamente'
            ]);
    }
}