<template>
  <v-card>
    <v-layout>
      <layout :rol="rolLayout"> </layout>
      <v-main>
        <v-container class="container">
          <div class="titul">
            <h1>Crear usuari</h1>
          </div>
          <!-- Camps de l'usuari -->
          <div class="divAltres">
            <h3>Nom</h3>

            <v-col cols="6">
              <v-text-field
                v-model="nom"
                ref="nom"
                clearable
                :rules="rules"
              ></v-text-field>
            </v-col>
          </div>

          <div class="divAltres">
            <h3>Correu</h3>

            <v-col cols="10">
              <v-text-field
                v-model="correu"
                ref="correu"
                clearable
                :rules="rules"
              ></v-text-field>
            </v-col>
          </div>

          <div class="divAltres">
            <h3>Contrasenya</h3>

            <v-col cols="10">
              <v-text-field
                v-model="contrasenya"
                ref="contrasenya"
                clearable
                :rules="rules"
              ></v-text-field>
            </v-col>
          </div>

          <div class="divAltres">
            <h3>Rol</h3>

            <v-select
              label="Rol"
              :items="['admin', 'tecnic', 'gestor']"
              clearable
              :rules="rules"
              v-model="rol"
            ></v-select>
          </div>
          <!-- Boto submite de tots els camps -->
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
import axios from "axios";

export default {
  components: { layout },
  name: "crearusuari",
  data() {
    return {
      nom: "",
      correu: "",
      contrasenya: "",
      rolLayout: "",
      loading: false,
      //Regles de camp requerit, si un camp esta buid et mostra el seguent text
      rules: [(v) => !!v || "Camp requerit"],
    };
  },
  methods: {
    //Metode de crear Usuaris
    crearUsuari() {
      // Li pasem per axios els valors posats anteriorment
      axios
        .post("http://taskhive.daw.institutmontilivi.cat/api/crearusuari/", {
          token: sessionStorage.tokenusuari,
          nom: this.nom,
          correu: this.correu,
          contrasenya: this.contrasenya,
          rol: this.rol,
        })
        .then((response) => {
          console.log(response);
          this.$router.push("/usuaris");
        })
        .catch((error) => {
          console.error(error); // manejar el error de la solicitud
        });
    },
  },
  created() {
    this.rolLayout = sessionStorage.rol;
  },
};
</script>

<style src="@/styles/settings.scss"></style>
