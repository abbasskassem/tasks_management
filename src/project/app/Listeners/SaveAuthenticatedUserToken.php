<?php

namespace App\Listeners;

use App\Core\Auth;
use App\Events\UserLoggedInEvent;


class SaveAuthenticatedUserToken
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserLoggedInEvent $event): void
    {
        Auth::saveToken($event->user);
    }
}
