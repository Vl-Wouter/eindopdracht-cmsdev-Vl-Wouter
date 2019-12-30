<template>
  <section :class="level">
    <p>
      <span class="bold" v-show="code"
        >{{ level | capitalize }} {{ code }}:</span
      >&nbsp;{{ message }}
    </p>
  </section>
</template>

<style lang="scss" scoped>
section {
  border-width: 0 0 0 4px;
  border-radius: 0 8px 8px 0;
  padding: 2px 0;
  border-style: solid;
  text-align: center;
}
p {
  font-size: 10px;
}

.bold {
  font-weight: 700;
}

.warning {
  background: rgb(255, 242, 205);
  color: rgb(190, 134, 11);
  border-left-color: rgb(190, 134, 11);
}

.error {
  background: rgb(255, 206, 206);
  color: rgb(172, 41, 41);
  border-color: rgb(172, 41, 41);
}
</style>

<script>
export default {
  name: "FormError",
  props: {
    level: String,
    code: Number,
    message: String
  },
  filters: {
    capitalize: value => {
      if (!value) return "";
      value = value.toString();
      return value.charAt(0).toUpperCase() + value.slice(1);
    }
  }
};
</script>
