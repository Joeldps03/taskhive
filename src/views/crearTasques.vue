<template>
  <v-card>
    <v-layout>
      <layout :rol="rol"> </layout>
      <v-main>
        <v-container class="container">
          <div class="titul">
            <h1>Crear tasca</h1>
          </div>
<!-- Camps de la tasca -->
          <div class="divAltres">
            <h3>Tasca</h3>

            <v-col cols="100">
              <v-text-field
                clearable
                :rules="rules"
                v-model="nom"
              ></v-text-field>
            </v-col>
          </div>

          <div class="divEPU">
            <div class="divCentreTasca">
              <h3>Estat</h3>

              <v-col cols="100">
                <v-select
                  clearable
                  :rules="rules"
                  v-model="estat"
                  :items="['pendent', 'cursant', 'acabada']"
                ></v-select>
              </v-col>
            </div>

            <div class="divCentreTasca">
              <h3>Prioritat</h3>

              <v-col cols="100">
                <v-text-field
                  clearable
                  :rules="rules"
                  v-model="prioritat"
                ></v-text-field>
              </v-col>
            </div>

            <div class="divCentreTasca">
              <h3>Usuari asignat</h3>

              <v-col cols="100">
                <v-text-field
                  clearable
                  :rules="rules"
                  v-model="id_usuari"
                ></v-text-field>
              </v-col>
            </div>
          </div>

          <div class="divEPU">
            <div class="divCentreTasca">
              <h3>Descripció</h3>

              <v-col cols="15">
                <v-textarea clearable v-model="descripcio"></v-textarea>
              </v-col>
            </div>

            <div class="divCentreTasca">
              <h3>Comentari</h3>

              <v-col cols="15">
                <v-textarea clearable v-model="comentaris_tecnics"></v-textarea>
              </v-col>
            </div>
          </div>
<!-- Boto submite de tots els camps -->
          <div class="buttonEditar2">
            <v-btn
              :loading="loading"
              color="blue"
              size="large"
              type="submit"
              variant="outlined"
              @click="crearTasques"
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
  name: "crearTasques",
  data() {
    
    return {
      nom: "",
      descripcio: "",
      id_usuari: "",
      prioritat: "",
      estat: "pendent",
      comentaris_tecnics: "",
      rol: "",
      loading: false,
      //Regles de camp requerit, si un camp esta buid et mostra el seguent text
      rules: [(v) => !!v || "Camp requerit"],
    };
  },
  methods: {

    //Metode de crear Tasques
    crearTasques() {
      // Li pasem per axios els valors posats anteriorment
      axios
        .post("http://taskhive.daw.institutmontilivi.cat/api/creartasca/", {
          token: sessionStorage.tokenusuari,
          nom: this.nom,
          descripcio: this.descripcio,
          id_usuari: this.id_usuari,
          prioritat: this.prioritat,
          estat: this.estat,
          comentaris_tecnics: this.comentaris_tecnics,
        })
        .then((response) => {
          //Rediracio
          this.$router.push("/tasques");
        })
        .catch((error) => {
          console.error(error); // Si hi ha error de solicitud el mostra
        });
    },
  },
  
  created(){
    this.rol = sessionStorage.rol;
  }
  
};
</script>

<style src="@/styles/settings.scss"></style>
