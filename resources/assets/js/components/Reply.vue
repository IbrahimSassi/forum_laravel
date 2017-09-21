<script>

    import Favorite from './Favorite.vue';

    export default{
        props: ['attributes'],
        components: {Favorite},
        data(){
            return {
                editing: false,
                body: this.attributes.body,
                loading: false
            }
        },
        methods: {
            update(){
                let baseUrl = "http://localhost:8000";
                this.loading = true;
                axios
                    .patch('/replies/' + this.attributes.id, {
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
                axios.delete('/replies/' + this.attributes.id)
                    .then((response) => {
                        if (response.status == 200) {
                            $(this.$el).fadeOut(300, () => {
                                flash('Your reply has been deleted');
                            });

                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            cancel(){
                this.editing = false;
                this.body = this.attributes.body;
            }
        }
    }
</script>