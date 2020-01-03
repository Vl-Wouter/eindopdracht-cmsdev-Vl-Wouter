<template>
  <main class="container">
    <router-link v-if="step == 1" to="/" class="backButton"
      ><font-awesome-icon icon="arrow-left" size="lg"
    /></router-link>
    <button
      v-if="step != 1"
      @click.prevent="goBack"
      class="backButton btn -empty"
    >
      <font-awesome-icon icon="arrow-left" size="lg" />
    </button>
    <h2 class="text-primary">Taak voltooien</h2>
    <section v-if="step == 1">
      <section v-if="tasks.length < 1">
        <p>Je hebt geen nieuwe taken meer.</p>
      </section>
      <section v-for="task in tasks" :key="task.id">
        <card class="clickable" @click.native="goToStep2(task.id)">
          <task :name="task.period.client" :date="task.date" />
        </card>
      </section>
    </section>
    <section v-if="step == 2">
      <p class="client">{{ currentTask.period.client | fullName }}</p>
      <p class="subtext">{{ currentTask.date | dateString }}</p>
      <task-form @submit.native.prevent="handleSubmit" :errors="errors" />
    </section>
  </main>
</template>

<style lang="scss" scoped>
.container {
  text-align: left;
  padding: 32px 16px;
  padding-bottom: 0;

  .backButton {
    color: app-color-level("primary", 3);
  }

  .text-primary {
    color: app-color-level();
  }

  .clickable {
    cursor: pointer;
  }

  .client {
    margin-bottom: 8px;
  }

  .subtext {
    font-size: 12px;
    color: app-color-level("foreground", 4);
  }

  .btn {
    &.-empty {
      border: none;
      background: none;
      cursor: pointer;
      color: app-color-level("primary", 3);
      font-size: 16px;
      margin: 0;
      padding: 0;
    }
  }
}

@keyframes arrow-left {
  0% {
    transform: translateX(0);
  }
  10% {
    transform: translateX(-50%);
  }
  20% {
    transform: translateX(0);
  }
}

@include desktop-up {
  .container {
    width: 65%;
    margin: 0 auto;

    .backButton {
      animation-name: arrow-left;
      animation-duration: 3s;
      animation-iteration-count: infinite;
    }
  }
}
</style>

<script>
import Card from "@/components/Card.vue";
import Task from "@/components/card-content/Task.vue";
import TaskForm from "@/components/forms/TaskForm.vue";
import { Api, FormSerializer, Validator } from "@/services";
export default {
  name: "TaskComplete",
  components: {
    Card,
    Task,
    TaskForm
  },
  data: () => {
    return {
      step: 1,
      currentTask: null,
      errors: null
    };
  },

  computed: {
    tasks() {
      return this.$store.getters.unfinishedTasks;
    },
    token() {
      return this.$store.state.userToken;
    }
  },
  created() {
    this.$store.commit("setTaskFlow", true);
  },
  beforeRouteLeave(to, from, next) {
    this.$store.commit("setTaskFlow", false);
    next();
  },

  methods: {
    goToStep2(id) {
      this.step++;
      this.currentTask = this.tasks.find(task => {
        return task.id == id;
      });
    },
    goBack() {
      this.step--;
      this.currentTask = null;
    },
    async handleSubmit() {
      this.errors = null;
      const form = document.querySelector("#taskForm");
      const object = FormSerializer.toJSON(form);
      const today = new Date();
      object.begin_time = `${today.getFullYear()}-${today.getMonth() +
        1}-${today.getDate()}T${object.begin_time}`;
      object.end_time = `${today.getFullYear()}-${today.getMonth() +
        1}-${today.getDate()}T${object.end_time}`;
      const { isValid, errors } = Validator.validateTaskDetail(object);

      if (!isValid) {
        this.errors = errors;
        return false;
      }
      try {
        await Api.updateTask(this.currentTask.id, object, this.token);
        this.$router.push({
          name: "home"
        });
      } catch (error) {
        const errorData = error.response.data;
        this.errors.unshift({
          level: "error",
          code: errorData.code,
          message: errorData.message
        });
      }
    }
  }
};
</script>
