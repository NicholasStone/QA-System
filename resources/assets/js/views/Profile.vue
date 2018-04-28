<template>
  <b-card>
    <b-form
      @submit.stop="update"
      @reset.stop="reset">
      <b-form-row>
        <b-col
          cols="8"
          offset="2">
          <b-form-group
            id="id"
            horizontal
            label="用户 ID"
            label-for="name"
            label-cols="3"
            label-class="text-sm-right">
            <b-input
              id="name"
              v-model="profile.id"
              disabled
            />
          </b-form-group>
          <b-form-group
            id="name-group"
            breakpoint="md"
            horizontal
            label="用户名"
            labal-cols="3"
            label-for="name"
            label-class="text-sm-right">
            <b-input
              id="name"
              v-model="name"
              :placeholder="profile.name"
            />
          </b-form-group>
          <b-form-group
            id="introduction"
            :state="introductionState"
            :invalid-feedback="introductionFeedback"
            :valid-feedback="introductionFeedback"
            breakpoint="md"
            horizontal
            label="自我简介"
            label-cols="3"
            label-for="name"
            label-class="text-sm-right"
            description="个人简介，请不要超过 50 个字">
            <b-form-textarea
              id="introduction"
              v-model="introduction"
              :state="introductionState"
              :placeholder="profile.introduction"
              rows="3"
              max-rows="6"
            />
          </b-form-group>
        </b-col>
        <div class="w-100"/>
        <b-col
          class="text-right"
          cols="2"
          offset="2">
          <p>头像</p>
        </b-col>
        <b-col cols="4">
          <b-img
            :src="profile.avatar"
            fluid
            class="img-thumbnail"
            @click="redirectToAvatar"/>
          <p class="text-muted text-center mt-auto mb-auto">
            <small>点击更换头像</small>
          </p>
        </b-col>
        <div class="w-100"/>
        <b-col offset="4">
          <b-button
            size="small"
            type="submit"
            variant="primary">
            提交
          </b-button>
          <b-button
            size="small"
            type="reset"
            variant="default">
            重置
          </b-button>
        </b-col>
      </b-form-row>
    </b-form>
  </b-card>
</template>

<script>
import {mapGetters} from 'vuex'

export default {
  name: 'Profile',
  data: function () {
    return {
      name: '',
      introduction: ''
    }
  },
  computed: {
    ...mapGetters(['profile']),
    introductionFeedback: function () {
      return this.introduction.length + '/50'
    },
    introductionState: function () {
      if (this.introduction.length === 0) {
        return null
      } else {
        return this.introduction.length <= 50
      }
    }
  },
  methods: {
    update: function () {
      this.$store.dispatch('updateProfile', {name: this.name, introduction: this.introduction})
        .then(this.reset())
    },
    reset: function () {
      this.name = ''
      this.introduction = ''
      this.show = false
      this.$nextTick(() => {
        this.show = true
      })
    },
    redirectToAvatar: function () {
      this.$router.push({name: 'Avatar'})
    }
  }
}
</script>

<style scoped>

</style>
