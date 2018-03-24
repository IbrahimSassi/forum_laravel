<template>

    <div>
        <div v-if="signedIn">
            <div class="form-group">
                <label for="body"></label>
                <textarea class="form-control" name="body" id="body"
                          cols="30" rows="5"
                          placeholder="Have something to say ?"
                          v-model="body"></textarea>
            </div>
            <button type="submit"
                    class="btn btn-default"
                    @click="addReply">Post
            </button>


            

        <button type="submit" class="btn btn-default"></button>



        </div>

        <div v-else>
            <p class="text-center"> Please <a href="/login">sign in</a> to participate</p>
        </div>


    </div>
</template>

<script>
    export default{
        data(){
            return {
                body: '',
                signedIn: window.App.signedIn
            };
        },
        computed: {},
        components: {},
        methods: {
            addReply(){
                axios.post(location.pathname + '/replies', {body: this.body})
                    .then((response) => {
                        this.body = '';
                        flash('Your reply has been posted');
                        this.$emit('created', response.data);
                    })
                    .catch((error) => {
                        console.log(error);

                    })
            }
        }

    }
</script>