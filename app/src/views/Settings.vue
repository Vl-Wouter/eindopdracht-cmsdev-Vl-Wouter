<template>
  <main class="settings" v-if="currentUser">
    <app-header class="header">
      <h2>Instellingen</h2>
      <h4>{{ currentUser.first_name + " " + currentUser.last_name }}</h4>
      <p>{{ currentUser.email }}</p>
      <p>{{ currentUser.roles[0] | role }}</p>
      <section class="rate">
        <div class="rate__type">
          <span>Tarief:</span
          ><span class="text-bold"
            >{{ currentUser.cost | currency }} / uur</span
          >
        </div>
        <div class="rate__type">
          <span>Transportkost:</span
          ><span class="text-bold"
            >{{ currentUser.transport | currency }} / km</span
          >
        </div>
      </section>
    </app-header>
    <section class="forms">
      <h2>Instellingen aanpassen</h2>
      <p class="text-danger" v-if="!isSubContractor">
        Je kan dit enkel als onderaannemer doen.
      </p>
      <settings-form
        v-else
        :error="errors[0]"
        :loading="loading"
        :values="currentUser"
        @submit.native.prevent="submitUpdate"
      />
    </section>
  </main>
  <main v-else>
    <font-awesome-icon icon="spinner" spin />
  </main>
</template>

<style lang="scss" scoped>
h4 {
  margin: 8px 0 4px;
}

.text-bold {
  font-weight: 700;
}

.text-danger {
  color: app-color-level("danger", -2);
}

.forms {
  padding: 0 32px;
}

.rate {
  &__type {
    margin: 8px 0;
    display: flex;
    justify-content: space-between;
  }
}

@include desktop-up {
  .settings {
    display: flex;
    flex-flow: row nowrap;
    width: 100%;
    height: calc(100vh - 64px);

    .header {
      flex: 0 0 50%;
    }

    .forms {
      flex: 0 0 50%;
      box-sizing: border-box;
    }
  }
}
</style>

<script>
import { Api, FormSerializer } from "@/services";
import AppHeader from "@/components/AppHeader";
import SettingsForm from "@/components/forms/SettingsForm";
export default {
  name: "Settings",
  components: {
    AppHeader,
    SettingsForm
  },
  data: () => ({
    currentUser: null,
    errors: [],
    loading: false
  }),
  computed: {
    isSubContractor() {
      if (this.currentUser) {
        return this.currentUser.roles.find(
          role => role === "ROLE_SUBCONTRACTOR"
        )
          ? true
          : false;
      } else {
        return false;
      }
    }
  },
  methods: {
    async fetchUserDetails() {
      const { userToken, userId } = this.$store.state;
      console.log("fetching data");
      const { data } = await Api.fetchUserDetails(userId, userToken);
      this.currentUser = data;
    },
    async submitUpdate() {
      this.loading = true;
      const form = document.querySelector("form");
      const json = FormSerializer.toJSON(form);
      try {
        const { userToken, userId } = this.$store.state;
        const { data } = await Api.updateUser(userId, json, userToken);
        this.currentUser = data;
      } catch (error) {
        const errorData = error.response.data;
        this.errors.unshift({
          level: "error",
          code: errorData.code,
          message: errorData.message
        });
      } finally {
        this.loading = false;
      }
    }
  },
  created() {
    this.fetchUserDetails();
  },
  filters: {
    role(input) {
      let string = input.toString();
      if (string === "") return "";
      const title = string.split("_")[1].toLowerCase();
      return title.charAt(0).toUpperCase() + title.slice(1);
    }
  }
};
</script>
