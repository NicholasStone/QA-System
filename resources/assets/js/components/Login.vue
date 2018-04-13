<template>
    <div>
        login
    </div>
</template>

<script>
    export default {
        name: "Login",
        data() {
            return {
                form: {
                    email,
                    password
                }
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