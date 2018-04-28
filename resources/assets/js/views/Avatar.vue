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
            alt="头像"/>
          <div class="text-center btn-container mt-2">
            <b-button
              type="button"
              variant="default"
              @click="select">
              选择文件
            </b-button>
            <b-button
              v-if="ready"
              type="button"
              variant="success"
              @click="upload">
              上传
            </b-button>
          </div>
          <form>
            <input
              id="image"
              hidden
              type="file"
              name="image"
              @change="fileChanged"
            >
          </form>
        </b-col>
      </b-card>
    </b-col>
  </b-row>
</template>

<script>
export default {
  name: 'Avatar',
  data () {
    return {
      image: '',
      file: null
    }
  },
  computed: {
    avatar: function () {
      return this.image.length === 0 ? this.$store.getters.avatar : this.image
    },
    ready: function () {
      return this.file !== null
    }
  },
  methods: {
    select: function () {
      document.getElementById('image').click()
    },
    fileChanged: function (e) {
      let files = e.target.files || e.dataTransfer.files
      if (files.length === 0) {
        return
      }
      let reader = new FileReader()
      reader.onload = e => {
        this.image = e.target.result
      }
      reader.readAsDataURL(files[0])
      this.file = files[0]
    },
    upload: function () {
      this.$store.dispatch('updateAvatar', this.file)
        .then(() => {
          this.$router.push({name: 'Profile'})
        })
    }
  }
}
</script>

<style scoped>
  .btn-container {
    width: 100%;
  }
</style>
