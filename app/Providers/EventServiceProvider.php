<?php

namespace App\Providers;

use App\Events\UploadImageEvent;
use App\Events\UserCreated;
use App\Events\UserDetailsEevent;
use App\Listeners\CreateUserDetails;
use App\Listeners\UploadImageListener;
use App\Listeners\UserDetailsListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        UserDetailsEevent::class => [
            UserDetailsListener::class,
        ],

        UploadImageEvent::class => [
            UploadImageListener::class,
        ],

      
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
