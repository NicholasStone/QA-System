<template>
  <div id="messages">
    <alert
      v-for="(message, index) in messages"
      :data-x="index"
      :key="index"
      :alerts="message"
      class="mb-1 mt-1 mr-2"
    />
  </div>
</template>

<script>
import {mapState} from 'vuex'

export default {
  name: 'Message',
  computed: {
    ...mapState({
      messages: state => state.message.messages
    })
  }
}
</script>

<style scoped>
  #messages {
    position: absolute;
    top: 70px;
    max-width: 500px;
    z-index: 1000;
    right: 0;
  }
</style>
