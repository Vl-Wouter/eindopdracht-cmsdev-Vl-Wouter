<template>
  <section>
    <section class="card__header">
      <span class="text-bold">{{ name | fullName }}</span>
      <span class="text-light">{{ date | relativeDate }}</span>
    </section>
  </section>
</template>

<style lang="scss" scoped>
.card__header {
  padding: 8px 0;
}

.text-light {
  font-size: 14px;
  color: app-color-level("foreground", 4);
}
</style>

<script>
export default {
  name: "Task",
  props: {
    name: Object,
    date: String
  }
};
</script>
