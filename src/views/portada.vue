<template >
  <div id="pantallaCarga"></div>

  <v-progress-linear
        :active="true"
        :indeterminate="true"
        absolute
        bottom
        color="blue"
      ></v-progress-linear>
</template>

<script lang="ts">
export default {
  name: "portada",
  methods: {
    redirect() {
      this.$router.push({ name: "iniciarSessio" });
    },
  },
  mounted() {
    setTimeout(() => {
      this.redirect();
    }, 3000);
  },
};
</script>

<style src="@/styles/settings.scss">

</style>