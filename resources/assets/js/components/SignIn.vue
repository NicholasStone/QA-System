<template>
    <div>
        <b-row class="justify-content-md-center">
            <b-col cols="8">
                <alert v-bind:alerts="alerts"></alert>
                <b-card id="sign-in"
                        title="登录"
                        sub-title="登录以进行下一步操作">
                    <b-form @reset="formReset" @submit="signIn">
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
                                          required
                                          placeholder="请输入密码">
                            </b-form-input>
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
                alerts:[
                    {
                        type: 'danger',
                        message: 'Error Demo'
                    },
                    {
                        type: 'success',
                        message: 'Success Demo'
                    }
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
            signIn: function (evt) {
                evt.preventDefault();
                console.log(this.form);
            }
        }
    }
</script>

<style scoped>

</style>