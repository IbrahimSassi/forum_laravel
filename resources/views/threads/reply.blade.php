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