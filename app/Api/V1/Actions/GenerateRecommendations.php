<?php

namespace App\Api\V1\Actions;

use App\User;
use App\ViewLog;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;

class GenerateRecommendations
{
    /**
     * @var Client
     */
    private $http;

    /**
     * @var User
     */
    private $user;

    public function __construct(Client $http, User $user)
    {
        $this->http = $http;
        $this->user = $user;
    }

    public function execute(?Collection $users = null): Collection
    {
        $apiKey = config('recommendations.api_key');
        $users = $users ?? $this->user->newQuery()->with('viewLogs')->get();
        $recommendations = collect();

        foreach ($users as $user) {
            foreach ($user->viewLogs as $log) {
                $response = $this->http->get("https://api.themoviedb.org/3/movie/{$log->imdb_id}/recommendations?api_key=$apiKey");

                if ($response->getStatusCode() !== 200) {
                    logs()->error('Error when looking for recommendation.', [
                        'imdb_id' => $log->imdb_id,
                        'user_id' => $user->id,
                    ]);
                    continue;
                }

                $body = json_decode($response->getBody(), true);
                $results = collect($body['results'])->map(function ($recommendation) use ($user) {
                    return ['imdb_id' => $recommendation['id'], 'user_id' => $user->id];
                });
                $recommendations->push($results->toArray());
            }
        }

        return $recommendations->flatten(1)->groupBy('user_id');
    }
}
