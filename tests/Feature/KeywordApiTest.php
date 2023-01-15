<?php

namespace Tests\Feature;

use App\Models\Keyword;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class KeywordApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var User */
        $this->user = User::factory()->create();
        $this->token = $this->user->createToken('Test')->plainTextToken;
        $this->keyword = Keyword::factory()->create([
            'user_id' => $this->user->id,
        ]);
    }

    /**
     * It should return a list of user keywords
     *
     * @return void
     */
    public function test_keywords_listing_endpoint()
    {
        $response = $this->get('/api/keywords', [
            'authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200);
        $response->assertJsonCount(1);
    }

    /**
     * It should return the search results of user keyword by ID
     *
     * @return void
     */
    public function test_keyword_results_endpoint()
    {
        $response = $this->get('/api/keywords/' . $this->keyword->id, [
            'authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json){
            return $json
                ->where('id', $this->keyword->id)
                ->hasAny([
                    'adwords',
                    'links',
                    'results',
                    'html',
                ])
                ->etc();
        });
    }

    /**
     * It should create user's keyword
     *
     * @return void
     */
    public function test_keyword_creating_endpoint()
    {
        $response = $this->post('/api/keywords', [
            'key' => 'test',
        ], [
            'authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(201);
        $response->assertJson(function (AssertableJson $json){
            return $json
                ->where('key', 'test')
                ->etc();
        });
    }
}
