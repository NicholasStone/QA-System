<template>
  <b-alert
    v-if="!alerts.read"
    :key="alerts.index"
    :variant="alerts.type"
    :show="alerts.expire"
    dismissible
    @dismissed="read(alerts.index)"
    @dismiss-count-down="countdownChange">
    {{ alerts.message }}<br>
    <small v-if="alerts.expire">此消息将在{{ countdown }}秒后关闭</small>
  </b-alert>
</template>

<script>
export default {
  name: 'Alert',
  props: {
    alerts: {
      type: Object,
      default: function () {
        return {
          type: 'light',
          message: '',
          index: 0,
          expire: false,
          local: true
        }
      }
    }
  },
  data () {
    return {
      countdown: this.alerts.expire
    }
  },
  methods: {
    read: function (index) {
      if (!this.alerts.local) {
        this.$store.dispatch('read', index)
      }
    },
    countdownChange: function (countdown) {
      this.countdown = countdown
    }
  }
}
</script>

<style scoped>

</style>
