<template>
  <div>
    <b-card>
      {{ profile }}
    </b-card>
  </div>
</template>

<script>
export default {
  name: 'Profile',
  computed: {
    profile: function () {
      return this.$store.getters.profile
    }
  }
}
</script>

<style scoped>

</style>
