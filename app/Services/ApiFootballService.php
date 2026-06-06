<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ApiFootballService
{
    /**
     * Retrieve live scores from API-Football, caching results for 60 seconds.
     * Fallback to realistic mock data if credentials are not configured.
     */
    public function getLiveScores(): array
    {
        $apiKey = config('services.api_football.key');
        $apiUrl = config('services.api_football.url', 'https://v3.football.api-sports.io');

        // Check if API key is not configured, fall back to mock data
        if (empty($apiKey)) {
            return $this->getMockLiveScores();
        }

        // Cache the live score response to prevent rate limiting
        return Cache::remember('api-football:live-scores', 60, function () use ($apiKey, $apiUrl) {
            try {
                $response = Http::withHeaders([
                    'x-apisports-key' => $apiKey,
                ])
                ->timeout(6)
                ->get("{$apiUrl}/fixtures", [
                    'live' => 'all',
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    return $data['response'] ?? [];
                }
            } catch (\Throwable $e) {
                logger()->error('API-Football Live Scores Request Failed: ' . $e->getMessage());
            }

            // Fallback to mock data if API call throws an error
            return $this->getMockLiveScores();
        });
    }

    /**
     * Generate structured mock live scores mirroring the API-Football schema.
     */
    private function getMockLiveScores(): array
    {
        return [
            [
                'fixture' => [
                    'id' => 1001,
                    'status' => ['long' => 'First Half', 'short' => '1H', 'elapsed' => 34],
                    'date' => now()->subMinutes(34)->toIso8601String(),
                ],
                'league' => [
                    'id' => 39,
                    'name' => 'Premier League',
                    'country' => 'England',
                    'logo' => 'https://media.api-sports.io/football/leagues/39.png',
                ],
                'teams' => [
                    'home' => ['name' => 'Arsenal', 'logo' => 'https://media.api-sports.io/football/teams/42.png'],
                    'away' => ['name' => 'Chelsea', 'logo' => 'https://media.api-sports.io/football/teams/49.png'],
                ],
                'goals' => ['home' => 2, 'away' => 1],
                'events' => [
                    ['time' => ['elapsed' => 12], 'team' => ['name' => 'Arsenal'], 'player' => ['name' => 'M. Ødegaard'], 'type' => 'Goal', 'detail' => 'Normal Goal'],
                    ['time' => ['elapsed' => 24], 'team' => ['name' => 'Chelsea'], 'player' => ['name' => 'C. Palmer'], 'type' => 'Goal', 'detail' => 'Penalty'],
                    ['time' => ['elapsed' => 31], 'team' => ['name' => 'Arsenal'], 'player' => ['name' => 'B. Saka'], 'type' => 'Goal', 'detail' => 'Normal Goal'],
                ]
            ],
            [
                'fixture' => [
                    'id' => 1002,
                    'status' => ['long' => 'Second Half', 'short' => '2H', 'elapsed' => 88],
                    'date' => now()->subMinutes(88)->toIso8601String(),
                ],
                'league' => [
                    'id' => 39,
                    'name' => 'Premier League',
                    'country' => 'England',
                    'logo' => 'https://media.api-sports.io/football/leagues/39.png',
                ],
                'teams' => [
                    'home' => ['name' => 'Manchester City', 'logo' => 'https://media.api-sports.io/football/teams/50.png'],
                    'away' => ['name' => 'Manchester United', 'logo' => 'https://media.api-sports.io/football/teams/33.png'],
                ],
                'goals' => ['home' => 3, 'away' => 3],
                'events' => [
                    ['time' => ['elapsed' => 15], 'team' => ['name' => 'Manchester United'], 'player' => ['name' => 'B. Fernandes'], 'type' => 'Goal', 'detail' => 'Normal Goal'],
                    ['time' => ['elapsed' => 27], 'team' => ['name' => 'Manchester City'], 'player' => ['name' => 'E. Haaland'], 'type' => 'Goal', 'detail' => 'Normal Goal'],
                    ['time' => ['elapsed' => 42], 'team' => ['name' => 'Manchester City'], 'player' => ['name' => 'K. De Bruyne'], 'type' => 'Goal', 'detail' => 'Normal Goal'],
                    ['time' => ['elapsed' => 55], 'team' => ['name' => 'Manchester United'], 'player' => ['name' => 'R. Hojlund'], 'type' => 'Goal', 'detail' => 'Normal Goal'],
                    ['time' => ['elapsed' => 71], 'team' => ['name' => 'Manchester City'], 'player' => ['name' => 'P. Foden'], 'type' => 'Goal', 'detail' => 'Normal Goal'],
                    ['time' => ['elapsed' => 84], 'team' => ['name' => 'Manchester United'], 'player' => ['name' => 'M. Rashford'], 'type' => 'Goal', 'detail' => 'Normal Goal'],
                ]
            ],
            [
                'fixture' => [
                    'id' => 1003,
                    'status' => ['long' => 'Halftime', 'short' => 'HT', 'elapsed' => 45],
                    'date' => now()->subMinutes(60)->toIso8601String(),
                ],
                'league' => [
                    'id' => 140,
                    'name' => 'La Liga',
                    'country' => 'Spain',
                    'logo' => 'https://media.api-sports.io/football/leagues/140.png',
                ],
                'teams' => [
                    'home' => ['name' => 'Real Madrid', 'logo' => 'https://media.api-sports.io/football/teams/541.png'],
                    'away' => ['name' => 'Barcelona', 'logo' => 'https://media.api-sports.io/football/teams/529.png'],
                ],
                'goals' => ['home' => 1, 'away' => 0],
                'events' => [
                    ['time' => ['elapsed' => 38], 'team' => ['name' => 'Real Madrid'], 'player' => ['name' => 'J. Bellingham'], 'type' => 'Goal', 'detail' => 'Normal Goal'],
                ]
            ],
            [
                'fixture' => [
                    'id' => 1004,
                    'status' => ['long' => 'First Half', 'short' => '1H', 'elapsed' => 12],
                    'date' => now()->subMinutes(12)->toIso8601String(),
                ],
                'league' => [
                    'id' => 135,
                    'name' => 'Serie A',
                    'country' => 'Italy',
                    'logo' => 'https://media.api-sports.io/football/leagues/135.png',
                ],
                'teams' => [
                    'home' => ['name' => 'AC Milan', 'logo' => 'https://media.api-sports.io/football/teams/489.png'],
                    'away' => ['name' => 'Inter Milan', 'logo' => 'https://media.api-sports.io/football/teams/505.png'],
                ],
                'goals' => ['home' => 0, 'away' => 2],
                'events' => [
                    ['time' => ['elapsed' => 4], 'team' => ['name' => 'Inter Milan'], 'player' => ['name' => 'L. Martinez'], 'type' => 'Goal', 'detail' => 'Normal Goal'],
                    ['time' => ['elapsed' => 9], 'team' => ['name' => 'Inter Milan'], 'player' => ['name' => 'H. Calhanoglu'], 'type' => 'Goal', 'detail' => 'Normal Goal'],
                ]
            ],
            [
                'fixture' => [
                    'id' => 1005,
                    'status' => ['long' => 'Second Half', 'short' => '2H', 'elapsed' => 56],
                    'date' => now()->subMinutes(56)->toIso8601String(),
                ],
                'league' => [
                    'id' => 2,
                    'name' => 'UEFA Champions League',
                    'country' => 'Europe',
                    'logo' => 'https://media.api-sports.io/football/leagues/2.png',
                ],
                'teams' => [
                    'home' => ['name' => 'Bayern Munich', 'logo' => 'https://media.api-sports.io/football/teams/157.png'],
                    'away' => ['name' => 'Paris Saint Germain', 'logo' => 'https://media.api-sports.io/football/teams/85.png'],
                ],
                'goals' => ['home' => 1, 'away' => 1],
                'events' => [
                    ['time' => ['elapsed' => 18], 'team' => ['name' => 'Paris Saint Germain'], 'player' => ['name' => 'K. Mbappé'], 'type' => 'Goal', 'detail' => 'Normal Goal'],
                    ['time' => ['elapsed' => 49], 'team' => ['name' => 'Bayern Munich'], 'player' => ['name' => 'H. Kane'], 'type' => 'Goal', 'detail' => 'Normal Goal'],
                ]
            ]
        ];
    }
}
