import Vue from "vue";
import App from "./App.vue";
import "./registerServiceWorker";
import router from "./router";
import store from "./store";
import { library } from "@fortawesome/fontawesome-svg-core";
import {
  faHome,
  faCog,
  faPlus,
  faArrowLeft,
  faSpinner
} from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import "@/filters";

library.add([faHome, faCog, faPlus, faArrowLeft, faSpinner]);

Vue.component("font-awesome-icon", FontAwesomeIcon);

Vue.config.productionTip = false;

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount("#app");
