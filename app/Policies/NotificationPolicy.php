<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Notifications\DatabaseNotification;

class NotificationPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct() {

    }
    //
    public function update(User $user, DatabaseNotification $notification)
    {
        return true;
        return $notification->belongsTo($user);

    }
}
