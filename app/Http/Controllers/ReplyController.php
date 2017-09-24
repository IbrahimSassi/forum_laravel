<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

class ReplyController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }
    /**
     * Fetch all relevant replies.
     *
     * @param int    $channelId
     * @param Thread $thread
     */
    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(20);
    }

    public function store($channelId, Thread $thread, Request $request)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);
        $reply = Reply::create([
            'body' => \request('body'),
            'user_id' => auth()->id(),
            'thread_id' => $thread->id
        ]);
//        $reply = $thread->addReply([
//            'body' => \request('body'),
//            'user_id' => auth()->id()
//        ]);

        if (\request()->expectsJson()) {
            return $reply->load('owner');
        }

        return back()
            ->with('flash_message', 'Your reply has been left');
    }


    public function destroy(Reply $reply)
    {

        $this->authorize('update', $reply);
//        if ($reply->user_id != auth()->id()) {
//            return response([], 403);
//        }
        $reply->delete();

        if (request()->expectsJson())
            return response([], 200);

        return back();
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->update(['body' => request('body')]);


        return $reply;
//        return back();
    }
}
