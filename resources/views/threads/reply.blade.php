<div class="panel panel-default">

    <div class="panel-heading">
        <div class="level">
            <h5 class="flex">
                <a href="/user/{{$reply->owner->id}}">{{$reply->owner->name}}</a> said :
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
        <span class=""> {{$reply->created_at->diffForHumans()}}</span>
        <hr>
    </div>
</div>