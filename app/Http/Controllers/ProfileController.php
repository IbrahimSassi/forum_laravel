<?php

namespace App\Http\Controllers;

use App\Activity;
use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        $profileUser = $user;
        $threads = $profileUser->threads()->paginate(5);
        $activities = Activity::feed($profileUser, 50);
//        return $activities;
        return view('profiles.show', compact('profileUser', 'threads', 'activities'));

    }

}
