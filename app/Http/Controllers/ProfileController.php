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
        $activities = $this->getActivities($profileUser);
//        return $activities;
        return view('profiles.show', compact('profileUser', 'threads', 'activities'));

    }

    /**
     * @param $profileUser
     * @return mixed
     */
    protected function getActivities($profileUser)
    {
        return $profileUser->activities()
            ->latest()
            ->with(['subject'])
            ->take(50)
            ->get()
            ->groupBy(function ($activity) {
                return $activity->created_at->format('Y-m-d');
            });
    }
}
