<template>

    <div>
        <div v-for="(reply,index) in items">
            <reply :data="reply" @deleted="remove(index,arguments)"></reply>
        </div>

        <new-reply :endpoint="endpoint" @created="add"></new-reply>

    </div>
</template>

<script>
    import Reply from './Reply.vue';
    import newReply from './newReply.vue';
    export default{
        props: ['data'],
        components: {Reply, newReply},
        data(){
            return {
                items: this.data,
                endpoint: location.pathname + '/replies'
            }
        },
        methods: {
            add(reply){
                this.items.push(reply);
                this.$emit('added');
            },
            remove(index, args){
                console.log(args[0]); //id
                this.items = this.items.filter((item) => item.id != args[0])
                this.$emit('removed');

            }
        }
    }
</script>