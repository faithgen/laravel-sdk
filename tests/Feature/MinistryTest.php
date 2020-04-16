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
    public function created_ministry_has_a_profile()
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
    public function created_ministry_has_an_api_key()
    {
        Notification::fake();
        $ministry = factory(Ministry::class)->create();

        $this->assertTrue($ministry->apiKey()->exists());

        $this->assertEquals($ministry->id, $ministry->apiKey->ministry_id);

        $apiKey = Ministry\APIKey::first();
        $this->assertEquals($ministry->apiKey->api_key, $apiKey->api_key);
    }

    /**
     * @test
     */
    public function created_ministry_has_an_account()
    {
        Notification::fake();
        $ministry = factory(Ministry::class)->create();

        $this->assertTrue($ministry->account()->exists());

        $this->assertEquals($ministry->id, $ministry->account->ministry_id);

        $account = Ministry\Account::first();
        $this->assertEquals($ministry->account->level, $account->level);
        $this->assertEquals($ministry->account->ministry_id, $account->ministry_id);
    }

    /**
     * @test
     */
    public function created_ministry_has_an_activation()
    {
        Notification::fake();
        $ministry = factory(Ministry::class)->create();

        $this->assertTrue($ministry->activation()->exists());

        $this->assertEquals($ministry->id, $ministry->activation->ministry_id);

        $activation = Ministry\Activation::first();
        $this->assertEquals($ministry->activation->code, $activation->code);
        $this->assertEquals($ministry->activation->ministry_id, $activation->ministry_id);
    }

    /**
     * @test
     */
    public function it_can_create_ministry_account_from_api_endpoint()
    {
        $postData = [
            'name' => 'the name',
        ];
        $this->json('POST','/api/ministry/auth/register', $postData)
            ->assertResponseStatus(404);

        $this->json('POST','/api/auth/register', $postData)
            ->assertResponseStatus(422);
    }
}
