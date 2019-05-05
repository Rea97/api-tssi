<?php

namespace App\Api\V1\Controllers;

use Dingo\Api\Http\Request;
use Dingo\Api\Http\Response;
use App\Http\Controllers\Controller;

class ViewLogController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'imdb_id' => 'required|string|max:255'
        ]);

        $viewLog = $request->user()->viewLogs()->create($data);

        return response()->json([
            'data' => $viewLog,
        ], Response::HTTP_CREATED);
    }
}
