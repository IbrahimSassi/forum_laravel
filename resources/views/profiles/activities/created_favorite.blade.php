@component('profiles.activities.activity')

    @slot('heading')
        <i class="glyphicon glyphicon-thumbs-up"></i> {{$profileUser->name}} liked {{$activity->subject->favorited->owner->name}}'s {{$activity->subject->favorited->thread ? 'comment' :'thread'}} on
        <a href="{{$activity->subject->favorited->path()}}">"{{$activity->subject->favorited->thread ? $activity->subject->favorited->thread->title : $activity->subject->favorited->title}}
            "</a>

    @endslot

    @slot('created_at')
        {{$activity->subject->favorited->created_at->diffForHumans()}}
    @endslot

    @slot('body')
        {{$activity->subject->favorited->body }}

    @endslot
@endcomponent
