<?php

namespace Tests\Feature;

use Tests\TestCase;

class Week10FeatureTest extends TestCase
{
    public function test_login_page_returns_successful_response(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_google_redirect_route_redirects_to_google(): void
    {
        config([
            'services.google.client_id' => 'testing-client-id',
            'services.google.client_secret' => 'testing-client-secret',
            'services.google.redirect' => 'http://localhost/auth/google/callback',
        ]);

        $response = $this->get('/auth/google/redirect');

        $response->assertStatus(302);
        $response->assertRedirectContains('accounts.google.com');
    }
}
