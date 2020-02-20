<?php

namespace App\Providers;

use App\Answer;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Policies\AnswerPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         'App\Model\Question' => 'App\Policies\QuestionPolicy',
         Answer::class => AnswerPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        \Gate::define('update-question', function ($user, $question) {
            return $user->id === $question->user_id;
        });

        \Gate::define('delete-question', function ($user, $question) {
            return $user->id === $question->user_id;
        });
    }
}
