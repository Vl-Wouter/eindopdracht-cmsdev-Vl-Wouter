<template>
  <section>
    <section class="card__header">
      <span class="text-bold">{{ task.period.client | fullName }}</span>
      <span class="date">{{ task.date | date }}</span>
    </section>
    <section v-if="task.activity" class="card__details">
      <span>{{ task.activity }}</span>
      <span>{{ task.begin_time | time }} — {{ task.end_time | time }}</span>
    </section>
    <section v-else class="card__details">
      <span>Geen activiteit opgenomen</span>
    </section>
  </section>
</template>

<script>
export default {
  name: "TaskWithDetails",
  props: {
    task: Object
  },
  filters: {
    fullName(input) {
      return `${input.first_name} ${input.last_name}`;
    },
    date(input) {
      const date = new Date(input);
      return date.toLocaleDateString("nl", {
        day: "numeric",
        month: "long"
      });
    }
  }
};
</script>
