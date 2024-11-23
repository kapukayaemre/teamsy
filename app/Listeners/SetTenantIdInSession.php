<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;

class SetTenantIdInSession
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
    public function handle(UserLoggedIn $event): void
    {
        session()->put('tenant_id', $event->user->tenant_id);
    }
}
