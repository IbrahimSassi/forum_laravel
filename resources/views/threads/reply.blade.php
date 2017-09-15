<div class="panel panel-default">

    <div class="panel-heading"><a href="/user/{{$reply->owner->id}}">{{$reply->owner->name}}</a> said :</div>
    <div class="panel-body">
        <article>
            <div class="body">
                {{$reply->body }}
            </div>
            <span class=""> {{$reply->created_at->diffForHumans()}}</span>
        </article>
        <hr>
    </div>
</div>