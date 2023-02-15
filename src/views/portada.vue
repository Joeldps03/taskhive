<template >
  <div id="pantallaCarga"></div>

  <v-progress-linear :active="true" :indeterminate="true" absolute bottom color="blue"></v-progress-linear>
</template>

<script>
import axios from 'axios'
export default {
  name: "portada",
  data() {
    return {
      tokenJSON: {},
    }
  },
  methods: {
    redirect() {
      this.$router.push({ name: "iniciarSessio" });
    },
    generarTokenConvidat() {
      //generem token convidats
      axios.get("http://localhost/taskhive/api")
        //pillem el valor de l'api i ho introduim dintre de resposta
        .then(resultat => {
          this.tokenJSON = resultat.data;
          sessionStorage.setItem("tokenconvidat", resultat.data)
          console.log("TOKEN "+ resultat.data);
        }
        );
    }
  },
  mounted() {
    console.log (" jjj");
    this.generarTokenConvidat();
    setTimeout(() => {
      this.redirect();
    }, 3000);
  },
};
</script>

<style src="@/styles/settings.scss">

</style>