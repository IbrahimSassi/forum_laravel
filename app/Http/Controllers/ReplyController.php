<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

class ReplyController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function store($channelId, Thread $thread, Request $request)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);
        $thread->addReply([
            'body' => \request('body'),
            'user_id' => auth()->id()
        ]);

        return back()
            ->with('flash_message', 'Your reply has been left');;
    }


    public function destroy(Reply $reply)
    {

        $this->authorize('update', $reply);
//        if ($reply->user_id != auth()->id()) {
//            return response([], 403);
//        }

        $reply->delete();
        return back();
    }
}
