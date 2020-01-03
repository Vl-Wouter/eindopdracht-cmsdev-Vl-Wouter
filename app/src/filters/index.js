import Vue from "vue";

Vue.filter("fullName", value => {
  return value && typeof value === "object"
    ? `${value.first_name} ${value.last_name}`
    : "";
});

Vue.filter("relativeDate", value => {
  if (!value) return "";
  const date = new Date(value);
  const today = new Date();
  const diff = (date.getTime() - today.getTime()) / (1000 * 3600 * 24);
  const rtf = new Intl.RelativeTimeFormat("nl", { numeric: "auto" });

  return rtf.format(Math.floor(diff), "day");
});

Vue.filter("dateString", value => {
  if (!value) return "";
  const date = new Date(value);
  return date.toLocaleDateString("nl", {
    day: "numeric",
    month: "long",
    year: "numeric"
  });
});

Vue.filter("time", value => {
  if (!value) return "";
  const datetime = new Date(value);
  return `${
    datetime.getHours() < 10 ? "0" + datetime.getHours() : datetime.getHours()
  }:${
    datetime.getMinutes() < 10
      ? "0" + datetime.getMinutes()
      : datetime.getMinutes()
  }`;
});

Vue.filter("currency", value => {
  if (!value) return "";
  return "€ " + value.toFixed(2);
});
