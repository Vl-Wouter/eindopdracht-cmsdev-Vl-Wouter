<template>
  <transition name="page">
    <main>
      <section class="login__header">
        <img
          src="../assets/Arte-tech-white.svg"
          alt="Logo"
          class="login__header__logo"
        />
        <h1>Arte-Tech</h1>
      </section>
      <section class="login__content">
        <h2>Log in.</h2>
        <LoginForm
          :submitFunction="getToken"
          :error="error"
          :loading="loading"
        />
      </section>
    </main>
  </transition>
</template>

<style lang="scss" scoped>
.login {
  &__header {
    height: 55vh;
    width: 100%;
    display: flex;
    flex-flow: column nowrap;
    justify-content: center;
    align-items: center;
    background: #0587dd;
    color: #ffffff;
    border-radius: 0 0 16px 16px;

    &__logo {
      width: 128px;
    }

    h1 {
      font-size: 32px;
    }
  }

  &__content {
    flex-flow: column nowrap;
    width: 100%;
    height: 45vh;
    padding: 0 32px;
    box-sizing: border-box;
    display: flex;
    align-items: center;
    justify-content: center;

    h2 {
      display: none;
    }
  }
}

.page-enter {
  opacity: 0;
}

.page-enter-to {
  opacity: 1;
}

.page-enter-active {
  transition: opacity 4s ease-out;
}

@media screen and (min-width: 900px) {
  main {
    display: flex;
    height: 100vh;

    .login {
      &__header {
        height: 100%;
        border-radius: 0;
      }

      &__content {
        height: 100%;
        padding: 0 128px;

        h2 {
          display: block;
        }
      }
    }
  }
}
</style>

<script>
// import axios from "axios";
import { Validator } from "../services";
import LoginForm from "@/components/forms/LoginForm.vue";
export default {
  components: {
    LoginForm
  },
  data: () => {
    return {
      loading: false,
      error: null
    };
  },

  beforeRouteEnter(to, from, next) {
    if (to.query.redirectFrom) {
      next(vm => {
        vm.error = {
          level: "warning",
          message: "Meld je aan om de applicatie te gebruiken.",
          code: null
        };
      });
    } else {
      next();
    }
  },

  methods: {
    async getToken() {
      try {
        this.loading = true;
        const userData = {
          username: document.querySelector("#username").value,
          password: document.querySelector("#password").value
        };

        const { isValid, errorMsg, field } = Validator.validate(userData);

        if (!isValid) {
          this.error = {
            level: "error",
            code: null,
            message: errorMsg
          };

          document.querySelector(`#${field}`).classList.add("-error");
          this.loading = false;
          return false;
        }
        await this.$store.dispatch("initApp", userData);
        this.$router.push({ name: "home" });
      } catch (error) {
        this.loading = false;
        if (error.response) {
          const { code, message } = error.response.data;
          this.error = {
            level: "error",
            message: message,
            code: code
          };
        } else {
          this.error = {
            level: "error",
            message: error,
            code: null
          };
        }
      }
    }
  }
};
</script>
