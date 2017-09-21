<template>
    <div :id="'reply-'+id" class="panel panel-default" v-cloak>

        <div class="panel-heading">
            <div class="level">
                <h5 class="flex">
                    <a :href="'/profiles/'+data.owner.name">{{data.owner.name}}</a> said :
                </h5>

                <div v-if="signedIn">
                    <favorite :reply="data"></favorite>
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
            <span class="badge pull-right"> {{data.created_at}}</span>
            <hr>
        </div>
        <div class="panel-body" v-else>
            <h6 class="text-center">Loading ...</h6>
        </div>


        <div class="panel-footer level" v-if="canUpdate">

            <button type="button" class="btn btn-info btn-xs mr-1"
                    @click="editing=true"
            >Edit
            </button>
            <button type="button" class="btn btn-danger btn-xs" @click="remove">Remove</button>
        </div>
    </div>
</template>

<script>
    import Favorite from './Favorite.vue';

    export default{
        props: ['data'],
        components: {Favorite},
        data(){
            return {
                editing: false,
                body: this.data.body,
                id: this.data.id,
                loading: false
            }
        },
        computed: {
            signedIn()
            {
                return window.App.signedIn;
            },
            canUpdate(){
                return this.authorize(user => user.id == this.data.user_id);
            }
        },
        methods: {
            update(){
                let baseUrl = "http://localhost:8000";
                this.loading = true;
                axios
                    .patch('/replies/' + this.data.id, {
                        body: this.body
                    })
                    .then((response) => {
                        this.body = response.data.body;
//                        setTimeout(() => {
                        this.loading = false;
//                        }, 1000);
                    });

                this.editing = false;
                flash('Updated yeah');
            },
            remove(){
                axios.delete('/replies/' + this.data.id)
                    .then((response) => {
                        if (response.status == 200) {
                            this.$emit('deleted', this.data.id);
//                            $(this.$el).fadeOut(300, () => {
//                                flash('Your reply has been deleted');
//                            });

                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            cancel(){
                this.editing = false;
                this.body = this.data.body;
            }
        }
    }
</script>