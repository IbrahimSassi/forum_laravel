@extends('layouts.app')

@section('content')
    <thread-view :initial-replies-count="{{$thread->replies_count}}" inline-template>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="level">

                                <h4 class="flex">
                                    <a href="{{route('profile',$thread->owner)}}">{{$thread->owner->name}} </a>
                                    posted : {{$thread->title}}</h4>
                                @can('update',$thread)
                                    <form action="{{$thread->path()}}" method="post">
                                        {{csrf_field()}}
                                        {{method_field('DELETE')}}

                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                @endcan

                            </div>
                        </div>

                        <div class="panel-body">
                            {{$thread->body }}
                            <hr>
                            <form method="post" action="/threads/{{$thread->id}}/favorites">
                                {{csrf_field()}}
                                <button {{$thread->isFavorited() ? 'disabled' : ''}} class="btn btn-success pull-right">
                                    Like
                                    <i
                                            class="glyphicon glyphicon-thumbs-up"></i></button>
                            </form>
                        </div>
                    </div>


                    <h3 class="panel-heading">Replies : </h3>
                    <replies @added="repliesCount++" @removed="repliesCount--"></replies>


                </div>

                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <p>
                                This thread was published {{$thread->created_at->diffForHumans()}} by
                                <a href="{{$thread->owner->id}}">{{$thread->owner->name}}</a> , and currently
                                has <span v-text="repliesCount"></span> {{str_plural('comment',$thread->replies_count)}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </thread-view>

@endsection
