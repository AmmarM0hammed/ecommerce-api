<?php

namespace App\Listeners;

use App\Events\UserDetailsEevent;
use App\Models\UserDetail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserDetailsListener
{

    public function handle(UserDetailsEevent $event): void
    {
       UserDetail::create([
        "user_id"=>$event->user->id,
       ]);
    }
}
