<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Api\V1\Actions\PersistUserRecommendations;

class GenerateUsersRecommendations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recommendations:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate movie recommendations for all the application\'s users.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(PersistUserRecommendations $persistUserRecommendations)
    {
        $persistUserRecommendations->execute();
    }
}
