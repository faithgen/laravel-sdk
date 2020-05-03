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

    private Ministry $ministry;

    protected function setUp(): void
    {
        parent::setUp();
        Notification::fake();
        $this->ministry = factory(Ministry::class)->create();
    }

    /**
     * @test
     */
    public function model_has_relationships()
    {
        $this->assertTrue($this->ministry->activation()->exists());
        $this->assertTrue($this->ministry->apiKey()->exists());
        $this->assertTrue($this->ministry->account()->exists());
        $this->assertTrue($this->ministry->profile()->exists());
    }

    /**
     * @test
     */
    public function it_can_create_a_ministry()
    {
        factory(Ministry::class, 3)->create();

        $this->assertCount(4, Ministry::all());

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

        $this->assertCount(5, Ministry::all());

        $lastMinistry = Ministry::latest()->first();
    }

    /**
     * @test
     */
    public function created_ministry_has_a_profile()
    {
        $this->assertTrue($this->ministry->profile()->exists());

        $this->assertEquals($this->ministry->id, $this->ministry->profile->ministry_id);

        $this->assertNull($this->ministry->profile->about_us);
    }

    /**
     * @test
     */
    public function created_ministry_has_an_api_key()
    {
        $this->assertTrue($this->ministry->apiKey()->exists());

        $this->assertEquals($this->ministry->id, $this->ministry->apiKey->ministry_id);

        $apiKey = Ministry\APIKey::first();
        $this->assertEquals($this->ministry->apiKey->api_key, $apiKey->api_key);
    }

    /**
     * @test
     */
    public function created_ministry_has_an_account()
    {
        $this->assertTrue($this->ministry->account()->exists());

        $this->assertEquals($this->ministry->id, $this->ministry->account->ministry_id);

        $account = Ministry\Account::first();
        $this->assertEquals($this->ministry->account->level, $account->level);
        $this->assertEquals($this->ministry->account->ministry_id, $account->ministry_id);
    }

    /**
     * @test
     */
    public function created_ministry_has_an_activation()
    {
        $this->assertTrue($this->ministry->activation()->exists());

        $this->assertEquals($this->ministry->id, $this->ministry->activation->ministry_id);

        $activation = Ministry\Activation::first();
        $this->assertEquals($this->ministry->activation->code, $activation->code);
        $this->assertEquals($this->ministry->activation->ministry_id, $activation->ministry_id);
    }

    /**
     * @test
     */
    public function ministry_can_log_in()
    {
        $insertData = [
            'id'         => Str::uuid()->toString(),
            'name'       => $this->faker->company,
            'email'      => 'test@gmail.com',
            'phone'      => $this->faker->phoneNumber,
            'password'   => Hash::make('secret'),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        Ministry::insert($insertData);

        $response = $this->post('api/auth/login', [
            'email'    => 'test@gmail.com',
            'password' => 'secret',
        ]);

        $response->assertStatus(200);

        $responseContent = json_decode($response->content());
        $this->assertArrayHasKey('ministry', (array) $responseContent);
        $this->assertArrayHasKey('token', (array) $responseContent);
    }

    /**
     * @test
     */
    public function it_can_create_ministry_account_from_api_endpoint()
    {
        $postData = [
            'name' => 'the name',
        ];
        $response = $this->post('api/auth/register', $postData);

        $response->assertStatus(422);
        $response->assertJson([

        ]);

        $postData = array_merge($postData, [
            'email'            => 'test@email.com',
            'password'         => 'secret',
            'confirm_password' => 'secret',
            'phone'            => '023456',
        ]);

        $response = $this->post('api/auth/register', $postData);

        $response->assertStatus(200);
        $response->assertJson([
            'ministry' => [
                'level' => 'Free',
            ],
        ]);
    }
}
