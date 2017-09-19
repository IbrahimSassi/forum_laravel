@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="page-header">
                    <h1>
                        {{$profileUser->name}}
                    </h1>
                </div>


                @foreach($activities as $date => $records)
                    <h3 class="page-header">
                        {{$date}}
                    </h3>
                    @foreach($records as $activity)

                        @if(view()->exists('profiles.activities.'.$activity->type))
                            @include('profiles.activities.'.$activity->type)
                        @endif

                    @endforeach
                @endforeach
            </div>
        </div>
    </div>

@endsection