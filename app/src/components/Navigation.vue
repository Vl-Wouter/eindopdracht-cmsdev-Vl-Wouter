<template>
  <nav class="nav">
    <router-link to="/" class="nav__item"
      ><font-awesome-icon icon="home" size="lg"
    /></router-link>
    <router-link to="/tasks/complete" class="nav__item -big">
      <font-awesome-icon icon="plus" size="lg" />
    </router-link>
    <router-link to="/settings" class="nav__item"
      ><font-awesome-icon icon="cog" size="lg"
    /></router-link>
  </nav>
</template>

<style lang="scss" scoped>
.nav {
  position: fixed;
  bottom: 0;
  height: 64px;
  box-shadow: 0 -3px 10px #00000020;
  width: 100%;
  display: flex;
  justify-content: space-around;
  align-items: center;

  &__item {
    height: 100%;
    display: flex;
    align-items: center;
    color: hsl(203, 94%, 79%);
    position: relative;

    &.router-link-exact-active {
      color: #0587dd;
      &:after {
        height: 8px;
        width: 100%;
        content: "";
        position: absolute;
        bottom: 0;
        background: #0587dd;
        border-radius: 8px 8px 0 0;
      }
    }

    &:hover {
      color: #0587dd;
    }

    &.-big {
      width: 72px;
      height: 72px;
      margin-bottom: 48px;
      border-radius: 50%;
      background: #0587dd;
      color: #fff;
      justify-content: center;
      box-shadow: 0 5px 10px #00000020;
    }
  }
}
</style>

<script>
export default {
  name: "Navigation"
};
</script>
