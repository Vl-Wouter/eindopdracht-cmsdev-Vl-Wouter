<template>
  <transition name="slide-up">
    <div class="home">
      <app-header>
        <h2>Overzicht</h2>
        <p>Laatste 7 dagen</p>
        <section class="overview__details">
          <p>{{ overview.cost | currency }}</p>
          <p>{{ overview.time }} uur</p>
        </section>
      </app-header>
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

@include desktop-up {
  .home {
    display: flex;
    flex-flow: row nowrap;
    justify-content: space-between;
    height: calc(100vh - 64px);
    width: 100%;

    .header {
      flex: 0 0 25%;
    }

    .overview__details {
      flex-flow: column nowrap;
      justify-content: center;
      align-items: flex-start;
    }

    .tasks {
      flex: 0 0 75%;
      display: flex;
      flex-flow: row wrap;
      box-sizing: border-box;
      align-items: flex-start;
      justify-content: flex-start;

      h2 {
        flex: 0 0 100%;
      }

      div {
        flex: 0 0 50%;
        padding: 2%;
        box-sizing: border-box;
      }
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
  },
  mounted() {
    this.$store.dispatch("updateTasks");
  }
};
</script>
