@component('profiles.activities.activity')

    @slot('heading')
        <i class="glyphicon glyphicon-thumbs-up"></i> {{$profileUser->name}} liked a {{$activity->subject->favorited->owner->name}}'s comment on
        <a href="{{$activity->subject->favorited->path()}}">"{{$activity->subject->favorited->thread->title}}"</a>

    @endslot

    @slot('created_at')
        {{$activity->subject->favorited->created_at->diffForHumans()}}
    @endslot

    @slot('body')
        {{$activity->subject->favorited->body }}

    @endslot
@endcomponent
