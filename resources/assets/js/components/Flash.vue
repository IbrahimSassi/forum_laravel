<template>
    <div id="flash" class="alert alert-success" v-show="show">
        <strong>Success!</strong> {{body}}.
    </div>

</template>

<script>
    export default {
        props: ['message'],
        mounted() {
            console.log('Component mounted.')
        },
        data(){
            return {
                body: '',
                show: false
            }
        },
        created(){
            if (this.message) {
                this.flash(this.message);
            }

            window.events.$on('flash', message => {
                this.flash(message);
            });
        },

        methods: {
            flash(message){
                this.show = true;
                this.body = message;

                this.hide();
            },
            hide(){
                setTimeout(() => {
                    this.show = false;
                }, 3000);
            }
        }
    }
</script>


<style>
    #flash {
        position: fixed;
        right: 25px;
        bottom: 25px;
    }
</style>