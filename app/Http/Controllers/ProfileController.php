<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        $profileUser = $user;
        $threads = $profileUser->threads()->paginate(5);
        $activities = $profileUser->activities()->with('subject')->paginate(1);
        return view('profiles.show', compact('profileUser', 'threads', 'activities'));

    }
}
