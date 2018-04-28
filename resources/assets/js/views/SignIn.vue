<template>
  <div>
    <b-row
      id="sign-in"
      class="justify-content-md-center">
      <b-col cols="8">
        <alert
          v-for="(alert, key, index) in alerts"
          :key="index"
          :alerts="alert"/>
        <b-card
          title="登录"
          sub-title="登录以进行下一步操作">
          <b-form
            @reset="formReset"
            @submit="authorization">
            <b-form-group
              id="email-group"
              label="电子邮箱"
              label-for="email"
              description="请输入您在此注册的邮件">
              <b-form-input
                id="email"
                v-model="form.email"
                type="email"
                required
                placeholder="请输入邮件"/>
            </b-form-group>
            <b-form-group
              id="password-group"
              label="密码"
              label-for="password">
              <b-form-input
                id="password"
                v-model="form.password"
                :state="passwordState"
                type="password"
                required
                aria-describedby="password-feedback"
                placeholder="请输入密码"/>
              <b-form-invalid-feedback id="password-feedback">
                密码需要至少6个字符
              </b-form-invalid-feedback>
            </b-form-group>
            <b-button
              type="submit"
              variant="primary">登录
            </b-button>
            <b-button
              type="reset"
              variant="default">清空
            </b-button>
          </b-form>
        </b-card>
      </b-col>
    </b-row>
  </div>
</template>

<script>
import _ from 'lodash'

export default {
  name: 'SignIn',
  data () {
    return {
      form: {
        email: '',
        password: ''
      },
      alerts: []
    }
  },
  computed: {
    passwordState: function () {
      return this.form.password === '' || this.form.password.length >= 6 ? null : false
    }
  },
  methods: {
    formReset: function (evt) {
      evt.preventDefault()
      this.form.email = ''
      this.form.password = ''
      this.show = false
      this.$nextTick(() => {
        this.show = true
      })
    },
    clearAlerts: function () {
      this.alerts.length = 0
    },
    authorization: function (evt) {
      evt.preventDefault()
      if (this.form.password.length >= 6) {
        this.$store
          .dispatch('authorize', this.form)
          .then(() => {
            this.$router.push('Home')
          })
          .catch(error => {
            this.clearAlerts()
            this.form.password = ''
            _.forEach(error, (val, key) => {
              this.alerts.push({index: key, expire: 10, type: 'danger', message: val, local: true})
            })
          })
      }
    }
  }
}
</script>

<style scoped>
  #sign-in {
    margin-top: 7%;
  }
</style>
