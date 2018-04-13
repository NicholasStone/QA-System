<template>
    <div>
        <b-row class="justify-content-md-center">
            <b-col cols="8">
                <b-card id="register"
                        title="注册"
                        sub-title="下一站，考拉">
                    <b-form @submit="validate" @reset="formReset">
                        <b-form-group id="name-group"
                                      label="昵称"
                                      label-for="name"
                                      description="选一个名字">
                            <b-form-input id="name"
                                          type="text"
                                          v-model="form.name"
                                          required
                                          :state="nameStates"
                                          aria-describedby="name-feedback"
                                          placeholder="请填写您的昵称">
                            </b-form-input>
                            <b-form-invalid-feedback id="name-feedback">
                                {{ errors.name }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                        <b-form-group id="email-group"
                                      label="电子邮箱"
                                      label-for="email"
                                      description="注意：您在注册后将不能修改邮箱">
                            <b-form-input id="email"
                                          type="email"
                                          v-model.lazy="form.email"
                                          required
                                          :state="emailStates"
                                          aria-describedby="email-feedback"
                                          placeholder="请填写您的电子邮件">
                            </b-form-input>
                            <b-form-invalid-feedback id="email-feedback">
                                {{ errors.email }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                        <b-form-group id="password-group"
                                      label="Password"
                                      label-for="password"
                                      description="请选择一个强密码，至少6个字符">
                            <b-form-input id="password"
                                          type="password"
                                          v-model="form.password"
                                          required
                                          :state="states.password"
                                          aria-describedby="password-feedback"
                                          placeholder="请在此填写密码">
                            </b-form-input>
                            <b-form-invalid-feedback id="password-feedback">
                                {{ errors.password }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                        <b-form-group id="password-repeat"
                                      label="确认密码"
                                      label-for="password"
                                      description="再次输入密码以进行确认">
                            <b-form-input id="password-repeat"
                                          type="password"
                                          v-model="form.passwordRepeat"
                                          required
                                          :state="states.passwordRepeat"
                                          aria-describedby="password-repeat-feedback"
                                          placeholder="请在此再次输入密码以进行确认">
                            </b-form-input>
                            <b-form-invalid-feedback id="password-repeat-feedback">
                                您两次输入的密码不一致
                            </b-form-invalid-feedback>
                        </b-form-group>
                        <b-button type="submit" variant="primary">注册</b-button>
                        <b-button type="reset" variant="default">重写</b-button>
                    </b-form>
                </b-card>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    export default {
        name: "Register",
        data() {
            return {
                errors: {
                    name: '',
                    email: '',
                    password: '',
                },
                form: {
                    name: '',
                    email: '',
                    password: '',
                    passwordRepeat: '',
                },
                states: {
                    password: null,
                    passwordRepeat: null
                }
            }
        },
        computed: {
            nameStates: function () {
                return this.errors.name === '' ? null : false;
            },
            emailStates: function () {
                return this.errors.email === '' ? null : false;
            },
            passwordStates: function () {
                this.status.password = this.errors.password === '' ? null : false;
            }
        },
        methods: {
            validate: function (evt) {
                evt.preventDefault();
                if (this.passwordLengthValidation() && this.repeatMatchsValidation()) {
                    this.register();
                }
            },
            formReset: function (evt) {
                evt.preventDefault();
                this.form.email = '';
                this.form.password = '';
                this.form.passwordRepeat = '';
                this.show = false;
                this.$nextTick(() => {
                    this.show = true
                });
            },
            repeatMatchsValidation: function () {
                this.states.passwordRepeat = this.form.passwordRepeat === this.form.password;
                return this.states.passwordRepeat;
            },
            passwordLengthValidation: function () {
                this.states.password = this.form.password.length >= 6;
                return this.states.password;
            },
            register: function () {
                this.axios.post('/user', this.form)
                    .then(response => {
                        console.log(response);
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors;
                    });
            }
        }
    }
</script>

<style scoped>
    #register {
        margin-top: 5%;
    }
</style>