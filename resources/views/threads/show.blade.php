@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">Forum Threads</div>

                    <div class="panel-body">
                        <h4>
                            <a href="#">{{$thread->creator->name}} </a>
                            posted : {{$thread->title}}</h4>
                        <div class="panel-body">
                            {{$thread->body }}
                        </div>
                        <hr>
                    </div>
                </div>

                <h3 class="panel-heading">Replies : </h3>
                @foreach($replies as $reply)
                    @include('threads.reply')
                @endforeach

                {{$replies->links()}}

                @if(auth()->check())
                    <form method="post" action="{{$thread->path().'/replies'}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="body"></label>
                            <textarea class="form-control" name="body" id="body" cols="30" rows="5"
                                      placeholder="Have something to say ?"></textarea>
                        </div>

                        <button class="btn btn-default" type="submit">Post</button>
                    </form>
                @else
                    <p class="text-center"> Please <a href="{{route('login')}}">sign in</a> to participate</p>
                @endif

            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p>
                            This thread was published {{$thread->created_at->diffForHumans()}} by
                            <a href="{{$thread->creator->id}}">{{$thread->creator->name}}</a> , and currently
                            has {{$thread->replies_count}} {{str_plural('comment',$thread->replies_count)}}
                        </p>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
