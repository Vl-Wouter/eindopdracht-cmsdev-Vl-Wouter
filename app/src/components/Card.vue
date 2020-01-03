<template>
  <main class="card">
    <slot></slot>
  </main>
</template>

<style lang="scss">
.card {
  width: 100%;
  border-radius: 8px;
  border: 1px solid app-color-level("primary", 5);
  box-shadow: 0 5px 10px #00000020;
  padding: 8px 16px;
  box-sizing: border-box;
  margin: 16px 0;

  &__header {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    width: 100%;

    .date {
      font-size: 14px;
    }

    .text-bold {
      font-weight: 700;
    }
  }

  &__details {
    display: flex;
    justify-content: space-between;
    width: 100%;
    font-size: 12px;
    color: app-color-level("foreground", 4);
    margin-top: 8px;
  }
}
</style>

<script>
export default {
  name: "taskCard",
  filters: {
    fullName(input) {
      return `${input.first_name} ${input.last_name}`;
    }
  }
};
</script>
