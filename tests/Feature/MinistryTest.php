<?php

namespace FaithGen\SDK\Feature;

use FaithGen\SDK\FaithGenSDKServiceProvider;
use FaithGen\SDK\Models\Ministry;
use Faithgen\Testimonies\TestimoniesServiceProvider;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class MinistryTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [FaithGenSDKServiceProvider::class];
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
        factory(Ministry::class, 3)->create();

        $this->assertCount(3, Ministry::all()->count());

        $insertData = [
            'name'=>$this->faker->company,
            'email'=>$this->faker->safeEmail,
            'phone'=>$this->faker->phoneNumber,
            'password'=>Hash::make('secret')
        ];
        $ministry = Ministry::create($insertData);

        $this->assertCount(4, Ministry::all()->count());

        $lastMinistry = Ministry::latest()->first();
        $this->assertEquals($insertData['name'], $lastMinistry->name);
        $this->assertEquals($insertData['email'], $lastMinistry->email);
        $this->assertEquals($insertData['phone'], $lastMinistry->phone);
    }
}
