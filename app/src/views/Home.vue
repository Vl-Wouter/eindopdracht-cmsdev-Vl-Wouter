<template>
  <transition name="slide-up">
    <div class="home">
      <app-header>
        <h2>Overzicht</h2>
        <p>Laatste 7 dagen</p>
        <section class="overview__details">
          <p>{{ overview.cost }} EUR</p>
          <p>{{ overview.time }} uur</p>
        </section>
      </app-header>
      <!-- <img alt="Vue logo" src="../assets/Arte-tech.svg" />
      <HelloWorld msg="Welcome to Your Vue.js App" /> -->
      <section v-if="tasks" class="tasks">
        <h2>Recente taken</h2>
        <div v-for="task in tasks" :key="task.id">
          <card>
            <task-with-details :task="task" />
          </card>
        </div>
      </section>
    </div>
  </transition>
</template>

<style lang="scss" scoped>
.home {
  .overview {
    &__details {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-family: $header-font-family;
      font-size: 32px;
      height: 50%;
      font-weight: $header-font-weight;
    }
  }
  .tasks {
    padding: 0 16px;
    text-align: left;
  }

  .tasks {
    h2 {
      color: app-color-level();
    }
  }
}
</style>

<script>
import Card from "@/components/Card";
import TaskWithDetails from "@/components/card-content/TaskWithDetails";
import AppHeader from "@/components/AppHeader";

export default {
  name: "home",
  components: {
    Card,
    TaskWithDetails,
    AppHeader
  },

  computed: {
    tasks() {
      return this.$store.getters.pastTasks;
    },
    overview() {
      return this.$store.getters.overview;
    }
  }
};
</script>
