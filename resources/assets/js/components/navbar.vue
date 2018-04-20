<template>
  <b-navbar
    :variant="variant"
    toggleable="md"
    type="light"
    fixed="top">
    <b-navbar-toggle target="nav_collapse"/>
    <b-navbar-brand
      v-if="!index"
      :to="{name: 'Index'}">
      {{ brand }}
    </b-navbar-brand>
    <b-collapse
      id="nav_collapse"
      is-nav>
      <b-navbar-nav v-if="!index">
        <b-nav-item href="#">我要答题</b-nav-item>
        <b-nav-item href="#">我要出题</b-nav-item>
        <b-nav-item href="#">试试手气</b-nav-item>
      </b-navbar-nav>
      <!-- Right aligned nav items -->
      <b-navbar-nav class="ml-auto">
        <b-nav-form v-if="!index">
          <b-form-input
            size="sm"
            class="mr-sm-2"
            type="text"
            placeholder="Search"/>
          <b-button
            size="sm"
            class="my-2 my-sm-0"
            type="submit">Search
          </b-button>
        </b-nav-form>
      </b-navbar-nav>
      <b-navbar-nav
        v-if="authenticated"
        class="ml-auto">
        <b-nav-item-dropdown
          right>
          <!-- Using button-content slot -->
          <template slot="button-content">
            <em>{{ name }}</em>
            <!--<b-img :src="avatar"/>-->
          </template>
          <b-dropdown-item :to="{ name: 'Home'}">主页</b-dropdown-item>
          <b-dropdown-item :to="{ name: 'Profile'}">个人信息</b-dropdown-item>
        </b-nav-item-dropdown>
      </b-navbar-nav>
      <b-navbar-nav
        v-else
        class="ml-auto">
        <b-nav-item
          :to="{ name: 'Sign-in'}"
          class="border-right"
        >登录
        </b-nav-item>
        <b-nav-item
          :to="{ name: 'Register'}"
        >
          注册
        </b-nav-item>
      </b-navbar-nav>
    </b-collapse>
  </b-navbar>
  <!-- navbar-1.vue -->
</template>

<script>
import {mapGetters} from 'vuex'
// import Config from '~/config'

export default {
  name: 'Navbar',
  data () {
    return {
      brand: '考拉',
      index: false,
      variant: 'fate',
      path: this.$route.path
    }
  },
  computed: {
    ...mapGetters([
      'name', 'authenticated'
    ])
  },
  watch: {
    '$route.path' (val) {
      this.index = val === '/'
      this.variant = val === '/' ? 'fate' : 'light'
    }
  },
  created: function () {
    this.index = this.path === '/'
    this.variant = this.path === '/' ? 'fate' : 'light'
  }
}
</script>

<style scoped>
  .divider {
    width: 2px;
    background-color: gray();
  }
</style>
