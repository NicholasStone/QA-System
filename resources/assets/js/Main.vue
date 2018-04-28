<template>
  <div id="app">
    <navbar/>
    <messages/>
    <b-container>
      <router-view/>
    </b-container>
    <content-footer/>
  </div>
</template>

<script>
import ContentFooter from './components/content-footer'
import Navbar from './components/navbar'
import Messages from './components/message'

export default {
  name: 'App',
  components: {
    'content-footer': ContentFooter,
    'navbar': Navbar,
    'messages': Messages
  }
}
</script>

<style>
  body, div, form, img, ul, ol, li, dl, dt, dd, form, p {
    margin: 0;
    padding: 0;
    border: 0 none;
    list-style: none outside none;
    text-decoration: none;
  }

  #app {
    height: 100%;
    margin-bottom: 100px; /* Margin bottom by footer height */
    margin-top: 70px;
  }

  * {
    border-radius: 0;
  }

  body{
    font-family: Raleway Helvetica, Tahoma, Arial, STXihei, "华文细黑", Heiti, "黑体", "Microsoft YaHei", "微软雅黑", SimSun, "宋体", sans-serif;
  }
</style>
