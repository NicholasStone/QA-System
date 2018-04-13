<template>
    <div>
        <b-row>
            <b-col cols="12">
                <h1 class="mt-5 title text-center">考拉</h1>
                <search></search>
                <div class="text-center">
                    <button class="btn btn-dark rounded-0 col-2 mr-5">手气不错</button>
                    <button class="btn btn-dark rounded-0 col-2">我要出题</button>
                </div>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    import Search from './partials/search'

    export default {
        name: 'Index',
        components: {
            'search': Search
        },
        data() {
            return {
                search: ''
            }
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    .title {
        font-size: 112px;
        font-family: "华文细黑", 'Microsoft YaHei', "微软雅黑", 'Noto Sans', serif;
    }

</style>
