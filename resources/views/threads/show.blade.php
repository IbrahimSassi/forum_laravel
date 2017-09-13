@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Forum Threads</div>

                    <div class="panel-body">
                        <article>
                            <h4>{{$thread->title}}</h4>
                            <div class="body">
                                {{$thread->body }}
                            </div>
                        </article>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Replies</div>

                    @foreach($thread->replies as $reply)
                        <div class="panel-body">
                            <article>
                                <h6 class="badge">{{$reply->owner->name}} said :</h6>
                                <div class="body">
                                    {{$reply->body }}
                                </div>
                                <span class=""> {{$reply->created_at->diffForHumans()}}</span>
                            </article>
                            <hr>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
