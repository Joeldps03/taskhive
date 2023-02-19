<template>
  <v-card>
    <v-layout>
      <layout> 
      </layout>
      <v-main>
        <v-container class="container">
          <div class="titul">
            <h1>Editar usuari</h1>
          </div>

          <div class="divAltres">
            <h3>Nom</h3>

            <v-col cols="6">
              <v-text-field  v-model="nom" clearable :rules="rules" ></v-text-field>
            </v-col>
          </div>

          <div class="divAltres">
          <h3>Correu</h3>

          <v-col cols="10">
            <v-text-field v-model="correu" clearable :rules="rules" ></v-text-field>
          </v-col>
          </div>

          <div class="divAltres">
          <h3>Contrasenya</h3>

          <v-col cols="10">
            <v-text-field v-model="contrasenya" clearable :rules="rules" ></v-text-field>
          </v-col>
          </div>

          <div class="divAltres">
            <h3>Rol</h3>

            <v-col cols="6">
              <v-text-field v-model="rol" clearable :rules="rules" ></v-text-field>
            </v-col>
          </div>

          <div class="buttonEditar2">
            <v-btn
              :loading="loading"
              color="blue"
              size="large"
              type="submit"
              variant="outlined"
              @click="editarUsuari()"
              
            >
              Editar
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
  name: "editarusuari",
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
    editarUsuari() {
      axios.post("http://localhost/api/editarusuari/", {
      token: sessionStorage.tokenusuari,
      nom: this.nom,
      email: this.correu,
      contrasenya: this.contrasenya,
      rol: this.rol,
  })
    .then(response => {
      console.log(response)
      this.$router.push("/usuaris");
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

<style src="@/styles/settings.scss">
v-table {
  @media (max-width: 992px) {
    thead {
      display: none;
    }

    tbody tr td {
      display: block;
      border-bottom: 1px solid rgba(0, 0, 0, 0.12);
    }
  }
}
</style>