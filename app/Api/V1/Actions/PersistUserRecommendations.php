<?php

namespace App\Api\V1\Actions;

use App\User;
use Illuminate\Support\Collection;

class PersistUserRecommendations
{
    /**
     * @var GenerateRecommendations
     */
    private $generateRecommendations;

    public function __construct(GenerateRecommendations $generateRecommendations)
    {
        $this->generateRecommendations = $generateRecommendations;
    }

    public function execute(?Collection $users = null)
    {
        $recommendations = $this->generateRecommendations->execute($users);

        foreach ($recommendations as $userId => $recommendation) {
            try {
                $user = User::query()->findOrFail($userId);
                $user->recommendations()->create([
                    'results' => collect($recommendation)
                        ->pluck('imdb_id')
                        ->unique()
                        ->random(config('recommendations.recommendations_results_limit'))
                        ->values()
                        ->toArray(),
                ]);
            } catch (\Exception $exception) {
                logs()->error('Error when saving recommendation.', ['user_id' => $userId]);
            }
        }
    }
}
