<template>
  <main class="h-100">
    <router-view></router-view>
  </main>
</template>

<script>
export default {
  name: "MainComponent",
  data() {
    return {};
  },
};
</script>

<style  lang="scss">
main {
  background-color: #9BD6CC;
  overflow: auto;
  margin-top: 70px;
  overflow-y: auto;
}

</style>
