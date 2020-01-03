<template>
  <form method="post">
    <form-error
      v-if="error"
      :code="error.code"
      :message="error.message"
      :level="error.level"
    />
    <text-field type="number" name="newCost" labelText="Nieuw tarief" />
    <text-field />
    <v-button type="submit" colors="primary">
      <span v-if="loading"><font-awesome-icon icon="spinner" spin/></span>
      <span v-else>Versturen</span>
    </v-button>
  </form>
</template>

<script>
import FormError from "./FormError";
import Button from "../Button";
import TextField from "./fields/TextField";
export default {
  name: "SettingsForm",
  components: {
    FormError,
    "v-button": Button,
    TextField
  },
  props: {
    error: Object,
    loading: Boolean,
    values: Object
  }
};
</script>

<style lang="scss" scoped></style>
