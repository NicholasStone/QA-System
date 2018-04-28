<template>
  <b-row>
    <b-col>
      <b-card>
        <b-col
          cols="6"
          offset="3">
          <b-img
            :src="avatar"
            fluid
            alt="头像"
          />
        </b-col>
      </b-card>
    </b-col>
  </b-row>
</template>

<script>
export default {
  name: 'Avatar',
  computed: {
    avatar: function () {
      return this.$store.getters.avatar
    }
  }
}
</script>

<style scoped>

</style>
