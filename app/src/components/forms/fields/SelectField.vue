<template>
  <section class="form__group">
    <label v-if="label" :for="fieldName">{{ labelText }}</label>
    <select :name="fieldName" :id="fieldName">
      <option
        v-for="(option, index) in options"
        :value="option.value"
        :key="index"
        >{{ option.label }}</option
      >
    </select>
  </section>
</template>

<style lang="scss" scoped>
@import "./field.scss";
select {
  appearance: none;
  background-image: url("https://api.iconify.design/ls:dropdown.svg");
  background-position: right 16px top 50%, 0 0;
  background-repeat: no-repeat, repeat;
  background-size: 0.65em auto, 100%;
}
</style>

<script>
export default {
  name: "SelectField",
  props: {
    label: Boolean,
    labelText: String,
    fieldName: String,
    options: Array
  }
};
</script>
