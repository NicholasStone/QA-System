<template>
    <div id="app">
        <navbar></navbar>
        <b-container>
            <router-view/>
        </b-container>
        <content-footer></content-footer>
    </div>
</template>

<script>
    import ContentFooter from './components/partials/content-footer'
    import Navbar from './components/partials/navbar'

    export default {
        name: 'App',
        components: {
            'content-footer': ContentFooter,
            'navbar': Navbar
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

    * {
        border-radius: 0;
    }

    #app {
        height: 100%;
        margin-bottom: 100px; /* Margin bottom by footer height */
        margin-top: 60px;
    }
</style>
