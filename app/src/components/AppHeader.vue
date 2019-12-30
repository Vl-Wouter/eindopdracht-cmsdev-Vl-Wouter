<template>
  <section class="header">
    <slot></slot>
  </section>
</template>

<style lang="scss" scoped>
.header {
  height: 35vh;
  background: app-color-level("primary");
  border-radius: 0 0 16px 16px;
  padding: 32px 16px 32px 16px;
  margin-bottom: 32px;
  box-sizing: border-box;
  text-align: left;
  color: app-color-level("background");

  h2,
  p {
    margin: 0;
  }
}
</style>

<script>
export default {
  name: "Header"
};
</script>
