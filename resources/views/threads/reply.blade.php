<reply inline-template>
    <div id="reply-{{$reply->id}}" class="panel panel-default">

        <div class="panel-heading">
            <div class="level">
                <h5 class="flex">
                    <a href="/profiles/{{$reply->owner->name}}">{{$reply->owner->name}}</a> said :
                </h5>
                <div>

                    <form action="/replies/{{$reply->id}}/favorites" method="post">
                        {{csrf_field()}}
                        <button type="submit" class="btn btn-default" {{$reply->isFavorited() ? 'disabled' : ''}}>
                            {{$reply->favorites_count}} ♥ {{str_plural('Favorite',$reply->favorites_count)}}
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="panel-body">
            {{$reply->body }}
            <span class="badge pull-right"> {{$reply->created_at->diffForHumans()}}</span>
            <hr>
        </div>

        @can('update',$reply)
            <div class="panel-footer level">

                <button type="button" class="btn btn-info btn-xs mr-1">Edit</button>

                <form action="/replies/{{$reply->id}}" method="post">
                    {{csrf_field()}}
                    {{method_field('DELETE')}}

                    <button type="submit" class="btn btn-danger btn-xs">Delete</button>
                </form>
            </div>
        @endcan
    </div>
</reply>