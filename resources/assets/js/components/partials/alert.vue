<template>
  <div>
    <b-alert
      v-for="(alert, key, index) in alerts"
      :key="index"
      :variant="alert.type"
      dismissible
      show>
      {{ alert.message }}
    </b-alert>
  </div>
</template>

<script>
export default {
  name: 'Alert',
  props: {
    'alerts': {
      type: Array,
      default: []
    }
  }
}
</script>

<style scoped>

</style>
