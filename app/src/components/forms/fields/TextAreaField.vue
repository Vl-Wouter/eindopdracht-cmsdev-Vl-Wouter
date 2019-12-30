<template>
  <section class="form__group">
    <label v-if="label" :for="fieldName">{{ labelText }}</label>
    <textarea :name="fieldName" :id="fieldName" cols="30" rows="3"></textarea>
  </section>
</template>

<style lang="scss" scoped>
@import "./field.scss";
</style>

<script>
export default {
  name: "TextAreaField",
  props: {
    label: Boolean,
    fieldName: String,
    labelText: String
  }
};
</script>
