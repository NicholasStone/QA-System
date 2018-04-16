<template>
  <b-container fluid>
    <footer class="footer">
      <div class="container">
        <p class="text-muted text-center">一切都是命运石之门的选择</p>
      </div>
    </footer>
  </b-container>
</template>

<script>
export default {
  name: 'ContentFooter'
}
</script>

<style scoped>
    .footer {
        position: relative;
        bottom: 0;
        width: 100%;
        height: 100px; /* Set the fixed height of the footer here */
        line-height: 100px; /* Vertically center the text there */
        /*background-color: #f5f5f5;*/
    }
</style>
