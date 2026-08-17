<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function test_landing_page_returns_200(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_landing_page_contains_brand_name(): void
    {
        $response = $this->get('/');
        $response->assertSee('SMILJAN');
    }

    public function test_landing_page_has_security_headers(): void
    {
        $response = $this->get('/');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->assertHeader('Cross-Origin-Opener-Policy', 'same-origin');
        $response->assertHeader('Content-Security-Policy');
    }

    public function test_sitemap_returns_xml(): void
    {
        $response = $this->get('/sitemap.xml');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml');
    }

    public function test_about_page_returns_200(): void
    {
        $response = $this->get('/tentang');
        $response->assertStatus(200);
    }

    public function test_menu_page_returns_200(): void
    {
        $response = $this->get('/menu');
        $response->assertStatus(200);
    }

    public function test_contact_page_returns_200(): void
    {
        $response = $this->get('/kontak');
        $response->assertStatus(200);
    }
}
