<template>

    <div>
        <div v-for="(reply,index) in items">
            <reply :data="reply" @deleted="remove(index,arguments)"></reply>
        </div>
    </div>
</template>

<script>
    import Reply from './Reply.vue';
    export default{
        props: ['data'],
        components: {Reply},
        data(){
            return {
                items: this.data
            }
        },
        methods: {
            remove(index, args){
                console.log(args[0]); //id
                this.items = this.items.filter((item) => item.id != args[0])
                this.$emit('removed');

            }
        }
    }
</script>