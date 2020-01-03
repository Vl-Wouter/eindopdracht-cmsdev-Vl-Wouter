<template>
  <nav class="nav">
    <section class="nav__brand">
      <h2>Arte-Tech</h2>
    </section>
    <section class="nav__links">
      <router-link to="/" class="nav__item"
        ><font-awesome-icon icon="home" size="lg" /><span
          >Home</span
        ></router-link
      >
      <router-link to="/tasks/complete" class="nav__item -big">
        <font-awesome-icon icon="plus" size="lg" />
      </router-link>
      <router-link to="/settings" class="nav__item"
        ><font-awesome-icon icon="cog" size="lg" /><span
          >Instellingen</span
        ></router-link
      >
    </section>
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

  &__brand {
    display: none;
  }

  &__links {
    display: flex;
    justify-content: space-around;
    align-items: center;
    height: 100%;
    width: 100%;
  }

  &__item {
    height: 100%;
    display: flex;
    align-items: center;
    color: hsl(203, 94%, 79%);
    position: relative;

    span {
      display: none;
    }

    &.router-link-exact-active {
      color: app-color-level();
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

@include desktop-up {
  .nav {
    position: inherit;
    display: flex;
    justify-content: space-between;

    &__brand {
      display: block;
      padding: 0 32px;
    }

    &__links {
      flex: 0 0 25%;
    }

    &__item {
      text-decoration: none;
      font-weight: 700;
      svg {
        display: none;
      }

      span {
        display: block;
      }

      &.-big {
        position: absolute;
        bottom: 32px;
        right: 32px;
        margin-bottom: 0;

        svg {
          display: block;
        }
      }
    }
  }
}
</style>

<script>
export default {
  name: "Navigation"
};
</script>
