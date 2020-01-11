<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeTest extends TestCase
{
    public function testHomePageIsWorkingCorrectly()
    {
        $response = $this->get('/');

		$response->assertSeeText('Welcome');
        $response->assertStatus(200);
    }
    public function testContactsPageIsWorkingCorrectly()
    {
        $response = $this->get('/contacts');

		$response->assertSeeText('Contacts');
        $response->assertStatus(200);
    }
}
