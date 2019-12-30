<template>
  <form id="taskForm" method="post">
    <div v-if="errors">
      <form-error
        :level="errors[0].level"
        :code="errors[0].code"
        :message="errors[0].message"
      />
    </div>
    <div class="form__row">
      <text-field
        label
        labelText="Startuur"
        type="time"
        name="begin_time"
        required
        class="-half"
      />
      <text-field
        label
        labelText="Einduur"
        type="time"
        name="end_time"
        required
        class="-half"
      />
    </div>
    <div class="form__row">
      <select-field
        label
        labelText="Pauze"
        fieldName="break"
        :options="selectOptions"
        class="-half"
      />
      <text-field
        label
        labelText="Transport"
        type="number"
        name="transport_distance"
        required
        class="-half"
      />
    </div>
    <text-area-field label labelText="Activiteiten" fieldName="activity" />
    <text-area-field label labelText="Materialen" fieldName="materials" />
    <Button type="submit" colors="primary" label="Voltooien" />
  </form>
</template>

<style lang="scss" scoped>
.form__row {
  width: 100%;
  display: flex;
  justify-content: space-between;
  box-sizing: border-box;

  .-half {
    flex: 0 0 50%;
    padding: 0 2%;
    box-sizing: border-box;

    &:first-child {
      padding-left: 0;
    }

    &:last-child {
      padding-right: 0;
    }
  }
}
</style>

<script>
import TextField from "./fields/TextField";
import TextAreaField from "./fields/TextAreaField";
import SelectField from "./fields/SelectField";
import FormError from "./FormError";
import Button from "../Button";
export default {
  name: "TaskForm",
  props: {
    errors: Array
  },
  components: {
    TextField,
    TextAreaField,
    SelectField,
    FormError,
    Button
  },
  data: () => {
    return {
      selectOptions: [
        { label: "Geen pauze", value: 0 },
        { label: "15 minuten", value: 0.25 },
        { label: "30 minuten", value: 0.5 },
        { label: "45 minuten", value: 0.75 },
        { label: "1 uur", value: 1 }
      ]
    };
  }
};
</script>
