@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="page-header"><h3>Forum Threads</h3></div>
                @forelse($threads as $thread)
                    <div class="panel panel-default">
                        <div class="panel-heading">

                            <div class="level">

                                <h4 class="flex">
                                    <a href="{{$thread->path()}}">
                                        @if($thread->hasUpdatesFor(auth()->user()))
                                            <strong>
                                                {{$thread->title}}
                                            </strong>
                                        @else
                                            {{$thread->title}}
                                        @endif
                                    </a>
                                </h4>
                                <a href="{{$thread->path()}}">{{$thread->replies_count}} {{str_plural('reply',$thread->replies_count)}}</a>
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="body">
                                {{$thread->body }}
                            </div>
                            <hr>
                        </div>
                    </div>
                @empty
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <h4 class="text-center">There no relevant results at this time</h4>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
