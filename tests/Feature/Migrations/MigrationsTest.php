<?php

namespace FaithDen\SDK\Tests\Feature\Migrations;

use FaithDen\SDK\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MigrationsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate', ['--database' => 'testing']);
    }

    /**
     * @test
     */
    public function it_runs_the_migration()
    {
        $this->assertFalse(DB::table('fg_ministries')->exists());

        $tableColumns = Schema::getColumnListing('fg_ministries');

        $this->assertIsArray($tableColumns);

        $this->assertTrue(in_array('name', $tableColumns));
        $this->assertTrue(in_array('email', $tableColumns));
        $this->assertTrue(in_array('phone', $tableColumns));
        $this->assertTrue(in_array('password', $tableColumns));
    }
}
