<template>
    <button type="submit" :class="classes" @click="toggle" :disabled="loading">
       <span class="glyphicon glyphicon-heart">
       </span>
        <span v-if="!loading" v-text="count"></span>
        <span v-else>
            <i style="font-size: small" class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
            <span class="sr-only">Loading...</span>
        </span>
    </button>

</template>

<script>
    export default{
        props: ['reply'],
        data(){
            return {
                count: this.reply.favoritesCount,
                active: this.reply.isFavorited,
                loading: false
            }
        },
        computed: {
            classes()
            {
                return ['btn', this.active ? 'btn-primary' : 'btn-default'];
            }
        },
        methods: {
            toggle(){
                this.loading = true;
                this.active ? this.unfavorite() : this.favorite();
            },
            favorite(){
                axios.post("/replies/" + this.reply.id + "/favorites")
                    .then(() => {
                        this.count++;
                        this.active = !this.active;
                        this.loading = false;
                    })
                    .catch(() => {
                        flash('You need to be connected to do that');
                        this.loading = false;
                    });
            },
            unfavorite(){
                axios.delete("/replies/" + this.reply.id + "/favorites")
                    .then(() => {
                        this.count--;
                        this.active = !this.active;
                        this.loading = false;
                    })
                    .catch(() => {
                        flash('You need to be connected to do that');
                        this.loading = false;
                    });
            }
        }
    }
</script>