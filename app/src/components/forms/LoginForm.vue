<template>
  <form v-on:submit.prevent="submitFunction" action method="POST">
    <FormError
      v-if="error"
      :code="error.code"
      :message="error.message"
      :level="error.level"
    />
    <TextField type="text" name="username" labelText="Gebruikersnaam" />
    <TextField type="password" name="password" labelText="Wachtwoord" />
    <Button type="submit" colors="primary">
      <span v-if="loading"><font-awesome-icon icon="spinner" spin/></span>
      <span v-else>Log in</span>
    </Button>
  </form>
</template>

<style lang="scss" scoped>
form {
  width: 100%;
}
</style>

<script>
import TextField from "./fields/TextField";
import Button from "../Button";
import FormError from "./FormError";
export default {
  name: "LoginForm",
  components: {
    TextField,
    Button,
    FormError
  },

  props: {
    error: Object,
    submitFunction: Function,
    loading: Boolean
  },

  methods: {}
};
</script>
