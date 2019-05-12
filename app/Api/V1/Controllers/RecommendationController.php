<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Actions\PersistUserRecommendations;
use App\Recommendation;
use App\User;
use Dingo\Api\Http\Request;
use Dingo\Api\Http\Response;
use App\Http\Controllers\Controller;

class RecommendationController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'data' => $request->user()->recommendations()->latest()->get(),
        ]);
    }

    public function store(Request $request, PersistUserRecommendations $persistUserRecommendations)
    {
        $persistUserRecommendations->execute(User::query()->where('id', auth()->id())->get());
        $recommendation = $request->user()->recommendations()->latest()->first();

        return response()->json([
            'data' => $recommendation,
        ], Response::HTTP_CREATED);
    }
}
