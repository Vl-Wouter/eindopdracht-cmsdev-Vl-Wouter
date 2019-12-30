<template>
  <main class="settings">
    <app-header>
      <h2>Instellingen</h2>
      <section class="rate">
        <div class="rate__type"><span>Tarief:</span><span>00,00 EUR</span></div>
        <div class="rate__type">
          <span>Transportkost:</span><span>00,00 EUR</span>
        </div>
      </section>
    </app-header>
  </main>
</template>

<style lang="scss" scoped>
.rate {
  &__type {
    margin: 8px 0;
    display: flex;
    justify-content: space-between;
  }
}
</style>

<script>
import AppHeader from "@/components/AppHeader";
export default {
  name: "Settings",
  components: {
    AppHeader
  },
  data: () => ({
    currentUser: null,
    errors: null
  }),
  methods: {
    async fetchUserDetails() {
      console.log("fetching data");
    }
  },
  created() {
    this.fetchUserDetails();
  }
};
</script>
