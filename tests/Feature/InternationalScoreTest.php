<?php

namespace Tests\Feature;

use App\Services\ApiFootballService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class InternationalScoreTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Clear cache before each test
        Cache::flush();
    }

    /**
     * Test page displays simulated mock data when API key is missing.
     */
    public function test_displays_mock_data_when_api_key_is_missing(): void
    {
        // Ensure config has empty key
        config(['services.api_football.key' => null]);

        $response = $this->get(route('international.score'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.international-score');
        $response->assertViewHas('isMock', true);
        $response->assertSee('Live Simulation Mode');
        $response->assertSee('Arsenal');
        $response->assertSee('Chelsea');
    }

    /**
     * Test page requests from direct API and displays live scores when key is present.
     */
    public function test_queries_api_football_and_renders_scores_when_key_is_present(): void
    {
        config([
            'services.api_football.key' => 'test-api-sports-key-123',
            'services.api_football.url' => 'https://v3.football.api-sports.io',
        ]);

        $mockApiResponse = [
            'response' => [
                [
                    'fixture' => [
                        'id' => 9999,
                        'status' => ['long' => 'First Half', 'short' => '1H', 'elapsed' => 15],
                        'date' => now()->toIso8601String(),
                    ],
                    'league' => [
                        'id' => 39,
                        'name' => 'Premier League Test',
                        'country' => 'England',
                        'logo' => 'https://media.api-sports.io/football/leagues/39.png',
                    ],
                    'teams' => [
                        'home' => ['name' => 'Red Devils', 'logo' => 'https://media.api-sports.io/football/teams/33.png'],
                        'away' => ['name' => 'City Blue', 'logo' => 'https://media.api-sports.io/football/teams/50.png'],
                    ],
                    'goals' => ['home' => 1, 'away' => 0],
                    'events' => [
                        ['time' => ['elapsed' => 10], 'team' => ['name' => 'Red Devils'], 'player' => ['name' => 'Bruno'], 'type' => 'Goal', 'detail' => 'Normal Goal'],
                    ],
                ]
            ]
        ];

        Http::fake([
            'v3.football.api-sports.io/fixtures*' => Http::response($mockApiResponse, 200),
        ]);

        $response = $this->get(route('international.score'));

        $response->assertStatus(200);
        $response->assertViewHas('isMock', false);
        $response->assertDontSee('Live Simulation Mode');
        $response->assertSee('Premier League Test');
        $response->assertSee('Red Devils');
        $response->assertSee('City Blue');

        // Assert HTTP call details
        Http::assertSent(function ($request) {
            return $request->hasHeader('x-apisports-key', 'test-api-sports-key-123') &&
                   str_contains($request->url(), 'https://v3.football.api-sports.io/fixtures') &&
                   $request['live'] === 'all';
        });
    }

    /**
     * Test page falls back gracefully to mock scores if API call fails.
     */
    public function test_falls_back_to_mock_data_on_api_failure(): void
    {
        config([
            'services.api_football.key' => 'test-api-sports-key-123',
            'services.api_football.url' => 'https://v3.football.api-sports.io',
        ]);

        Http::fake([
            'v3.football.api-sports.io/*' => Http::response([], 500),
        ]);

        $response = $this->get(route('international.score'));

        // It should still succeed (falling back to mock data)
        $response->assertStatus(200);
        $response->assertSee('Arsenal'); // From mock data
    }
}
