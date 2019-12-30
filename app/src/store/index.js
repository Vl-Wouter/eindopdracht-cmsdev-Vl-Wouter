import Vue from "vue";
import Vuex from "vuex";
import axios from "axios";

Vue.use(Vuex);

const store = new Vuex.Store({
  state: {
    userToken: null,
    userId: null,
    tasks: null,
    taskFlow: false
  },
  mutations: {
    setUserId: (state, id) => (state.userId = id),
    setToken: (state, token) => (state.userToken = token),
    clearToken: state => (state.userToken = null),
    setTasks: (state, tasks) => (state.tasks = tasks),
    setTaskFlow: (state, taskFlow) => (state.taskFlow = taskFlow)
  },
  getters: {
    pastTasks: state =>
      state.tasks
        ? state.tasks.filter(task => {
            const taskDate = new Date(task.date);
            const today = new Date();
            return (
              (taskDate < today && taskDate.getDate() < today.getDate()) ||
              task.status == 1
            );
          })
        : null,
    unfinishedTasks: state =>
      state.tasks
        ? state.tasks.filter(task => {
            const taskDate = new Date(task.date);
            const today = new Date();
            return taskDate.getDate() == today.getDate() &&
              taskDate.getMonth() == today.getMonth() &&
              taskDate.getFullYear() == today.getFullYear() &&
              task.status == 0
              ? true
              : false;
          })
        : null,
    overview: (state, getters) => {
      // Get tasks for the past period
      const lastWeekTasks = getters.pastTasks.filter(task => {
        const earliest = new Date().getDate() - 7;
        return new Date(task.date).getDate() > earliest;
      });
      // Calculate cost and hours for these tasks
      let cost = 0;
      let time = 0;
      lastWeekTasks.forEach(task => {
        cost += task.cost;
        time +=
          new Date(task.end_time).getHours() -
          new Date(task.begin_time).getHours();
      });
      // Return as object
      return {
        cost,
        time
      };
    }
  },
  actions: {
    async fetchJWT(userdata) {
      const { data } = await axios.post(
        "http://localhost:8000/api/token",
        userdata,
        {
          timeout: 5000
        }
      );
      return data;
    },
    async initApp({ commit }, userdata) {
      const { data: user } = await axios.post(
        "http://localhost:8000/api/token",
        userdata,
        {
          timeout: 5000
        }
      );
      const { data } = await axios.get(
        `http://localhost:8000/api/tasks/${user.user}`,
        {
          headers: {
            Authorization: `Bearer ${user.token}`
          }
        }
      );
      commit("setToken", user.token);
      commit("setUserId", user.user);
      commit("setTasks", data);
    }
  }
});

export default store;
