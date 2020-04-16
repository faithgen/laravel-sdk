<?php

namespace FaithGen\SDK\Tests\Feature;

use FaithDen\SDK\Tests\TestCase;
use FaithGen\SDK\Models\Ministry;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class MinistryTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function model_has_relationships()
    {
        $model = $this->mock(Ministry::class);

        //todo
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function it_can_create_a_ministry()
    {
        Notification::fake();

        factory(Ministry::class, 3)->create();

        $this->assertCount(3, Ministry::all());

        $insertData = [
            'id'         => Str::uuid()->toString(),
            'name'       => $this->faker->company,
            'email'      => $this->faker->safeEmail,
            'phone'      => $this->faker->phoneNumber,
            'password'   => Hash::make('secret'),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $ministry = Ministry::insert($insertData);

        $this->assertCount(4, Ministry::all());

        $lastMinistry = Ministry::latest()->first();
    }

    /**
     * @test
     */
    public function created_ministry_has_profile()
    {
        Notification::fake();
        $ministry = factory(Ministry::class)->create();

        $this->assertTrue($ministry->profile()->exists());

        $this->assertEquals($ministry->id, $ministry->profile->ministry_id);

        $this->assertNull($ministry->profile->about_us);
    }

    /**
     * @test
     */
    public function created_ministry_has_api_key()
    {
        Notification::fake();
        $ministry = factory(Ministry::class)->create();

        $this->assertTrue($ministry->apiKey()->exists());

        $this->assertEquals($ministry->id, $ministry->apiKey->ministry_id);

      //  $this->assertEquals($ministry->profile->about_us);
    }
}
