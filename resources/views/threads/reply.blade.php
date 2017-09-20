<reply :attributes="{{$reply}}" inline-template v-cloak>
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
        <div class="panel-body" v-if="!loading">

            <div v-if="editing">
                <div class="form-group">
                    <label for="body"></label>
                    <textarea v-model="body" class="form-control" id="body" name="body">
                    </textarea>
                </div>
                <button type="button"
                        class="btn btn-xs btn-primary"
                        @click="update"
                >Update
                </button>
                <button type="button"
                        class="btn btn-xs btn-link"
                        @click="cancel"
                >Cancel
                </button>
            </div>

            <div v-else v-text="body">
            </div>
            <span class="badge pull-right"> {{$reply->created_at->diffForHumans()}}</span>
            <hr>
        </div>
        <div class="panel-body" v-else>
            <h6 class="text-center">Loading ...</h6>
        </div>


        @can('update',$reply)
            <div class="panel-footer level">

                <button type="button" class="btn btn-info btn-xs mr-1"
                        @click="editing=true"
                >Edit
                </button>

                {{--<form action="/replies/{{$reply->id}}" method="post">--}}
                    {{--{{csrf_field()}}--}}
                    {{--{{method_field('DELETE')}}--}}

                    {{--<button type="submit" class="btn btn-danger btn-xs">Delete</button>--}}
                {{--</form>--}}

                <button type="button" class="btn btn-danger btn-xs" @click="remove">Remove</button>
            </div>
        @endcan
    </div>
</reply>