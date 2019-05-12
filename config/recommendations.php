<?php

return [
    'api_key' => env('MOVIES_API_KEY'),
    'recommendations_results_limit' => env('RECOMMENDATIONS_RESULTS_LIMIT', 5),
    'recommendations_generation_period' => env('RECOMMENDATIONS_GENERATION_PERIOD', 7) // in days
];
