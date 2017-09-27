<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserNotificationController extends Controller
{

    function __construct()
    {
        $this->middleware('auth');
    }


    public function index(User $user)
    {
        return auth()->user()->unreadNotifications;
    }

    public function destroy(User $user, $notificationId)
    {

        auth()->user()->notifications()->findOrFail($notificationId)->markAsRead();
    }
}
