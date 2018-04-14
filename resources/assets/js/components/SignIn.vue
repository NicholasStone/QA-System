<template>
    <div>
        <b-row class="justify-content-md-center">
            <b-col cols="8">
                <alert v-bind:alerts="alerts"></alert>
                <b-card id="sign-in"
                        title="登录"
                        sub-title="登录以进行下一步操作">
                    <b-form @reset="formReset" @submit="authorization">
                        <b-form-group id="email-group"
                                      label="Email"
                                      label-for="email"
                                      description="请输入您在此注册的邮件">
                            <b-form-input id="email"
                                          type="email"
                                          v-model="form.email"
                                          required
                                          placeholder="请输入邮件">
                            </b-form-input>
                        </b-form-group>
                        <b-form-group id="password-group"
                                      label="密码"
                                      label-for="password">
                            <b-form-input id="password"
                                          type="password"
                                          v-model="form.password"
                                          :state="passwordState"
                                          required
                                          aria-describedby="password-feedback"
                                          placeholder="请输入密码">
                            </b-form-input>
                            <b-form-invalid-feedback id="password-feedback">
                                密码需要至少6个字符
                            </b-form-invalid-feedback>
                        </b-form-group>
                        <b-button type="submit" variant="primary">登录</b-button>
                        <b-button type="reset" variant="default">清空</b-button>
                    </b-form>
                </b-card>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    export default {
        name: "SignIn",
        data() {
            return {
                form: {
                    email: '',
                    password: ''
                },
                alerts: [
                    // {
                    //     type: 'danger',
                    //     message: 'Error Demo'
                    // },
                ]
            }
        },
        methods: {
            formReset: function (evt) {
                evt.preventDefault();
                this.form.email = '';
                this.form.password = '';
                this.show = false;
                this.$nextTick(() => {
                    this.show = true
                });
            },
            authorization: function (evt) {
                evt.preventDefault();
                if (this.form.password >= 6) {
                    this.axios.post('/authorization', this.form)
                        .then(response => console.log(response))
                        .catch(error => console.log(error.response.data.errors))
                }
            }
        },
        computed: {
            passwordState: function () {
                return this.form.password === '' ? null :
                    this.form.password.length >= 6
            }
        }
    }
</script>

<style scoped>
#sign-in{
    margin-top: 5%;
}
</style>