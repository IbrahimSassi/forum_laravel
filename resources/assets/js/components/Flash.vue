<template>
    <div id="flash" :class='"alert alert-"+type' v-show="show">
        {{body}}.
    </div>

</template>

<script>
  export default {
    props: ['message'],
    mounted() {
      console.log('Component mounted.')
    },
    data() {
      return {
        body: '',
        type: 'success',
        show: false,
      }
    },
    created() {
      if (this.message) {
        this.flash(this.message);
      }

      window.events.$on('flash', (message, type) => {
        this.flash(message, type);
      });
    },

    methods: {
      flash(message, type = 'success') {
        this.show = true;
        this.body = message;
        if (type) {
          this.type = type;
        }
        this.hide();
      },
      hide() {
        setTimeout(() => {
          this.show = false;
        }, 4000);
      },
    },
  }
</script>


<style>
    #flash {
        position: fixed;
        right: 25px;
        bottom: 25px;
    }
</style>