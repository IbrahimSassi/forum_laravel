<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Reply;
use App\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function storeReply(Reply $reply)
    {
        $reply->favorite(auth()->id());
    }

    public function storeThread(Thread $thread)
    {
        $thread->favorite(auth()->id());
    }

    public function destroyReply(Reply $reply)
    {
        $reply->unfavorite();
    }
}
