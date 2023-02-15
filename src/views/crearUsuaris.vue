<template>
  <v-card>
    <v-layout>
      <layout> </layout>
      <v-main>
        <v-container class="container">
          <div class="titul">
            <h1>Crear usuari</h1>
          </div>

          <div class="divAltres">
            <h3>Nom</h3>

            <v-col cols="6">
              <v-text-field ref="nom" clearable :rules="rules"></v-text-field>
            </v-col>
          </div>

          <div class="divAltres">
          <h3>Correu</h3>

          <v-col cols="10">
            <v-text-field ref="correu" clearable :rules="rules"></v-text-field>
          </v-col>
          </div>

          <div class="divAltres">
          <h3>Contrasenya</h3>

          <v-col cols="10">
            <v-text-field ref="contrasenya" clearable :rules="rules"></v-text-field>
          </v-col>
          </div>

          <div class="divAltres">
            <h3>Rol</h3>

            <v-col cols="6">
              <v-text-field ref="rol" clearable :rules="rules"></v-text-field>
            </v-col>
          </div>

          <div class="buttonEditar2">
            <v-btn
              :loading="loading"
              color="blue"
              size="large"
              type="submit"
              variant="outlined"
              @click="crearUsuari"
            >
              Crear
            </v-btn>
          </div>
        </v-container>
      </v-main>
    </v-layout>
  </v-card>
</template>

<script>
import layout from "@/layouts/default/layout.vue";
import axios from 'axios';

export default {
  components: { layout },
  name: "editarUsuaris",
  data() {
    return {
      nom: '',
      correu: '',
      contrasenya: '',
      rol: '',
      loading: false,
      rules: [
        v => !!v || 'Camp requerit'
      ]
    };
  },
  methods: {
    crearUsuari() {
  axios.post('http://ejemplo.com/api/crear_usuari', {
    nom: this.nom,
    correu: this.correu,
    contrasenya: this.contrasenya,
    rol: this.rol,
  })
    .then(response => {
      console.log(response.data); // hacer algo con la respuesta de la API
    })
    .catch(error => {
      console.error(error); // manejar el error de la solicitud
    });
},
  },
};
</script>

<style src="@/styles/settings.scss">

</style>