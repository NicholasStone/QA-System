<template>
  <div>
    <b-alert
      v-for="(alert, key, index) in alerts"
      :key="index"
      :variant="alert.type"
      :show="10"
      dismissible>
      {{ alert.message }}
    </b-alert>
  </div>
</template>

<script>
export default {
  name: 'Message'
}
</script>

<style scoped>

</style>
