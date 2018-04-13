<template>
    <div>
        <b-alert v-for="(alert, key, index) in alerts" :key="index"
                 :variant="alert.type"
                 dismissible
                 show>
            {{ alert.message }}
        </b-alert>
    </div>
</template>

<script>
    export default {
        name: "alert",
        props: {
            'alerts': Array
        }
    }
</script>

<style scoped>

</style>