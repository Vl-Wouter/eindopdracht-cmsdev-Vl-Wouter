<template>
  <button :type="type" :class="colors">
    <slot></slot>
  </button>
</template>

<style lang="scss" scoped>
button {
  width: 100%;
  border-radius: 8px;
  background: none;
  border: none;
  padding: 16px 16px;
  box-sizing: border-box;
  cursor: pointer;

  &.primary {
    background: #0587dd;
    color: white;
  }
}
</style>

<script>
export default {
  name: "Button",
  props: {
    colors: String,
    label: String,
    type: String
  }
};
</script>
