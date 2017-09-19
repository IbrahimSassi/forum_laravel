@component('profiles.activities.activity')

    @slot('heading')
        <i class="glyphicon glyphicon-comment"></i>  {{$profileUser->name}} replied to <a
                href="{{$activity->subject->thread->path()}}">"{{$activity->subject->thread->title}}"</a>

    @endslot

    @slot('created_at')
        {{$activity->subject->created_at->diffForHumans()}}
    @endslot

    @slot('body')
        {{$activity->subject->body }}

    @endslot
@endcomponent
