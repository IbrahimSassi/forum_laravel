@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="page-header">
            <h1>
                {{$profileUser->name}}
                <small>since {{$profileUser->created_at->diffForHumans()}}</small>
            </h1>
        </div>


        @foreach($threads as $thread)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="level">
                        <h4 class="flex">
                            <a href="#">{{$thread->creator->name}} </a>
                            posted : {{$thread->title}}
                        </h4>
                        <span class="badge">
                            {{$thread->created_at->diffForHumans()}}
                        </span>
                    </div>

                </div>

                <div class="panel-body">
                    {{$thread->body }}
                    <hr>
                </div>
            </div>
        @endforeach
        {{$threads->links()}}
    </div>
@endsection