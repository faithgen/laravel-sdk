<?php

namespace FaithGen\SDK\Feature;

use FaithGen\SDK\Models\Ministry;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MinistryTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
    }

    /**
     * @test
     */
    public function it_can_create_a_ministry()
    {
        factory(Ministry::class, 3)->create();

        $this->assertCount(3, Ministry::all()->count());
    }
}
