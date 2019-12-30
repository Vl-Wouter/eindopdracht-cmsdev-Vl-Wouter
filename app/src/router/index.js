import Vue from "vue";
import VueRouter from "vue-router";
import Home from "../views/Home.vue";
import Settings from "../views/Settings.vue";
import store from "../store";

Vue.use(VueRouter);

const routes = [
  {
    path: "/",
    name: "home",
    component: Home
  },
  {
    path: "/about",
    name: "about",
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () =>
      import(/* webpackChunkName: "about" */ "../views/About.vue")
  },
  {
    path: "/login",
    name: "login",
    component: () => import("../views/Login.vue")
  },
  {
    path: "/tasks/complete",
    name: "listTasks",
    component: () => import("../views/TaskComplete.vue")
  },
  {
    path: "/settings",
    name: "settings",
    component: Settings
  }
];

const router = new VueRouter({
  mode: "history",
  routes
});

router.beforeEach((to, from, next) => {
  if (to.path != "/login") {
    if (!store.state.userToken)
      next({
        name: "login",
        query: {
          redirectFrom: to.fullPath
        }
      });
    else next();
  } else {
    if (store.state.userToken)
      next({
        path: from.fullPath
      });
    else next();
  }
});

export default router;
