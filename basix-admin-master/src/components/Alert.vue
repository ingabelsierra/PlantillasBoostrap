<template>
  <transition name="fade">
    <div class='basix-alert alert' :class="alertClass" v-if="!hidden">
        <slot></slot>
        <i class="fa fa-close alert-close float-right align-text-top" v-if="withCloseBtn" @click="hide()" ></i>
    </div>
  </transition>
</template>

<script>
  export default {
    name: 'basix-alert',
    computed: {
      alertClass () {
        return {
          'with-close': this.withCloseBtn,
          'alert-success': this.type === 'success',
          'alert-primary': this.type === 'primary',
          'alert-secondary': this.type === 'secondary',
          'alert-danger': this.type === 'danger',
          'alert-warning': this.type === 'warning',
          'alert-info': this.type === 'info'
        }
      }
    },
    props: {
      type: {
        type: String,
        default: 'success'
      },
      withCloseBtn: {
        type: Boolean,
        default: false
      }
    },
    data () {
      return {
        hidden: false
      }
    },
    methods: {
      hide () {
        this.hidden = true
      }
    }
  }
</script>

<style lang='scss' scoped>
   .fade-enter-active, .fade-leave-active {
    transition: opacity .5s
  }
  .fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */ {
    opacity: 0
  }
</style>
