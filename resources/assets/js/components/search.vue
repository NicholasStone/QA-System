<template>
  <b-form
    inline
    class="page-center mb-3">
    <div class="form-group col-12 input-group-lg">
      <label
        for="search-input"
        class="sr-only">搜索</label>
      <input
        id="search-input"
        type="text"
        name="search-input"
        placeholder="找份卷子做做..."
        class="form-control offset-2 col-7 mt-4 mb-4 rounded-0">
      <button class="btn btn-dark btn-lg rounded-0 col-1">搜索</button>
    </div>
  </b-form>
</template>

<script>
export default {
  name: 'Search'
}
</script>

<style scoped>

</style>
