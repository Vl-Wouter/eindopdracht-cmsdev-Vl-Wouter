<template>
  <section class="form__group">
    <label v-if="label" :for="name">{{ labelText }}</label>
    <input
      v-on:focus="clearError"
      :type="type"
      :name="name"
      :id="name"
      :placeholder="labelText"
      :step="step"
      :value="value"
    />
  </section>
</template>

<style lang="scss" scoped>
@import "./field.scss";
</style>

<script>
export default {
  name: "TextField",
  props: {
    label: Boolean,
    labelText: String,
    name: String,
    type: String,
    required: Boolean,
    value: [String, Number],
    step: String
  },

  methods: {
    clearError() {
      const input = this.$el.children[this.$el.children.length - 1];
      input.classList.remove(".-error");
    }
  }
};
</script>
