@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Create a new thread</div>
                    <div class="panel-body">
                        <form method="post" action="/threads">
                            {{csrf_field()}}

                            <div class="form-group">
                                <label for="channel_id">Choose a Channel</label>
                                <select class="form-control" id="channel_id" name="channel_id" required>
                                    <option value="">Choose one</option>
                                    @foreach($channels as $channel)
                                        <option value="{{$channel->id}}" {{old('channel_id')==$channel->id ? 'selected' : ''}} >{{$channel->name}}</option>
                                    @endforeach

                                </select>
                            </div>


                            <div class="form-group">
                                <label for="title">Title : </label>
                                <input type="text" class="form-control" id="title" name="title" value="{{old('title')}}"
                                       required>
                            </div>

                            <div class="form-group">
                                <label for="body">Body : </label>
                                <textarea class="form-control" id="body" name="body" rows="8">
                                </textarea>
                            </div>


                            <button type="submit" class="btn btn-primary">Publish</button>

                        </form>

                        @include('layouts.errors')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
