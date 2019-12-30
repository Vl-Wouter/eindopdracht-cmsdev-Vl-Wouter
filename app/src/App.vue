<template>
  <div id="app">
    <!-- <div v-show="this.$store.state.userToken" id="nav">
      <router-link to="/">Home</router-link>
      | <router-link to="/about">About</router-link> |
      <router-link to="/login">Login</router-link>
    </div> -->
    <navigation v-show="this.hideNav" />
    <router-view />
  </div>
</template>

<style lang="scss">
@import "./sass/utils/_fonts.scss";
body {
  margin: 0;
  padding: 0;
  font-size: 16px;
}
#app {
  // // font-family: "Avenir", Helvetica, Arial, sans-serif;
  // font-family: "Open Sans", Helvetica, sans-serif;
  // -webkit-font-smoothing: antialiased;
  // -moz-osx-font-smoothing: grayscale;
  // text-align: center;
  // color: #2c3e50;
  // background: #fefefe;
  font-family: $base-font-family;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: app-color("foreground");
  background: app-color("background");
}

h1,
h2,
h3 {
  font-family: "Poppins", Helvetica, sans-serif;
  font-weight: 700;
}

#nav {
  padding: 30px;

  a {
    font-weight: bold;
    color: #2c3e50;

    &.router-link-exact-active {
      color: #42b983;
    }
  }
}

.child-view {
  transition: all 0.25s ease-out;
}

.slide-left-enter,
.slide-right-leave-active {
  transform: translateX(100vw);
}

.slide-left-leave-active,
.slide-right-enter {
  transform: translateX(-100vw);
}
</style>

<script>
import Navigation from "@/components/Navigation.vue";
export default {
  components: {
    Navigation
  },
  data: () => {
    return {
      transitionName: ""
    };
  },
  computed: {
    hideNav() {
      return this.$store.state.userToken
        ? this.$store.state.taskFlow
          ? false
          : true
        : false;
    }
  },
  watch: {
    $route(to, from) {
      const toDepth = to.path.split("/").length;
      const fromDepth = from.path.split("/").length;
      this.transitionName = toDepth < fromDepth ? "slide-right" : "slide-left";
    }
  }
};
</script>
