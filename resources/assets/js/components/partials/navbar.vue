<template>
    <b-navbar toggleable="md" type="light" v-bind:variant="variant" fixed="top">

        <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>

        <b-navbar-brand :to="{name: 'Index'}" v-if="!index">{{ brand }}</b-navbar-brand>

        <b-collapse is-nav id="nav_collapse">

            <b-navbar-nav v-if="!index">
                <b-nav-item href="#">我要答题</b-nav-item>
                <b-nav-item href="#">我要出题</b-nav-item>
                <b-nav-item href="#">试试手气</b-nav-item>
            </b-navbar-nav>

            <!-- Right aligned nav items -->
            <b-navbar-nav class="ml-auto">

                <b-nav-form v-if="!index">
                    <b-form-input size="sm" class="mr-sm-2" type="text" placeholder="Search"/>
                    <b-button size="sm" class="my-2 my-sm-0" type="submit">Search</b-button>
                </b-nav-form>

                <b-nav-item :to="{ name: 'Register'}">注册</b-nav-item>
                <b-nav-item :to="{ name: 'Sign-in'}">登录</b-nav-item>
                <b-nav-item-dropdown right>
                    <!-- Using button-content slot -->
                    <template slot="button-content">
                        <em>User</em>
                    </template>
                    <b-dropdown-item :to="{ name: 'Register'}">注册</b-dropdown-item>
                    <b-dropdown-item :to="{ name: 'Home'}">主页</b-dropdown-item>
                    <b-dropdown-item :to="{ name: 'Sign-in'}">登录</b-dropdown-item>
                </b-nav-item-dropdown>
            </b-navbar-nav>

        </b-collapse>
    </b-navbar>

    <!-- navbar-1.vue -->
</template>

<script>
    export default {
        name: 'navbar',
        data() {
            return {
                brand: '考拉',
                index: false,
                variant: 'fate',
                path: this.$route.path
            }
        },
        created: function () {
            this.index = this.path === '/';
            this.variant = this.path === '/' ? 'fate' : 'light'
        },
        watch: {
            '$route.path'(val) {
                this.index = val === '/';
                this.variant = val === '/' ? 'fate' : 'light';
            }
        }
    }
</script>

<style scoped>

</style>
