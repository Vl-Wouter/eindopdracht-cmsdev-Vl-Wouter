module.exports = {
  css: {
    loaderOptions: {
      sass: {
        prependData: `
          @import "@/sass/utils/_fonts.scss";
          @import "@/sass/utils/_variables.scss";
          @import "@/sass/utils/_functions.scss";
          @import "@/sass/utils/_mixins.scss";
        `
      }
    }
  }
};
