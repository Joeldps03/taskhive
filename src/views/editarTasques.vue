<template>
  <v-card>
    <v-layout>
      <layout> </layout>
      <v-main>
        <v-container class="container">
          <div class="titul">
            <h1>Editar tasca</h1>
          </div>

          <div v-if="userRole != 'tecnic'">
            <div class="divAltres">
              <h3>Tasca</h3>

              <v-col cols="100">
                <v-text-field
                  clearable
                  :rules="rules"
                  v-model="nom"
                  :label="this.desserts.length > 0 ? this.desserts[0].nom : ''"
                  
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
                    :items="['pendent', 'cursant', 'acabada']"
                    v-model="estat"
                    :label="this.desserts.length > 0 ? this.desserts[0].estat : ''"

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
                    :label="this.desserts.length > 0 ? this.desserts[0].prioritat : ''"

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
                    :label="this.desserts.length > 0 ? this.desserts[0].id_usuari : ''"

                  ></v-text-field>
                </v-col>
              </div>
            </div>

            <div class="divEPU">
              <div class="divCentreTasca">
                <h3>Descripció</h3>

                <v-col cols="15">
                  <v-textarea clearable v-model="descripcio"
                  :label= "this.desserts.length > 0 ? this.desserts[0].descripcio : ''"

                  ></v-textarea>
                </v-col>
              </div>

              <div class="divCentreTasca">
                <h3>Comentari</h3>

                <v-col cols="15">
                  <v-textarea
                    clearable
                    v-model="comentaris_tecnics"
                    :label="this.desserts.length > 0 ? this.desserts[0].comentaris_tecnics : ''"

                  ></v-textarea>
                </v-col>
              </div>
            </div>
          </div>

          <div v-else-if="userRole === 'tecnic'">
            <div class="divAltres">
              <h3>Tasca</h3>

              <v-col cols="100">
                <v-text-field
                  clearable
                  :rules="rules"
                  v-model="nom"
                  :label="this.desserts.length > 0 ? this.desserts[0].nom : ''"
                  readonly
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
                    :label="this.desserts.length > 0 ? this.desserts[0].estat : ''"
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
                    :label="this.desserts.length > 0 ? this.desserts[0].prioritat : ''"
                    readonly
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
                    :label="this.desserts.length > 0 ? this.desserts[0].id_usuari : ''"
                    readonly
                  ></v-text-field>
                </v-col>
              </div>
            </div>

            <div class="divEPU">
              <div class="divCentreTasca">
                <h3>Descripció</h3>

                <v-col cols="15">
                  <v-textarea
                    clearable
                    v-model="descripcio"
                    :label="this.desserts.length > 0 ? this.desserts[0].descripcio : ''"
                    readonly
                  ></v-textarea>
                </v-col>
              </div>

              <div class="divCentreTasca">
                <h3>Comentari</h3>

                <v-col cols="15">
                  <v-textarea
                    clearable
                    v-model="comentaris_tecnics"
                    :label="this.desserts.length > 0 ? this.desserts[0].comentaris_tecnics : ''"
                  ></v-textarea>
                </v-col>
              </div>
            </div>
          </div>

          <div class="buttonEditar2">
            <v-btn
              :loading="loading"
              color="blue"
              size="large"
              type="submit"
              variant="outlined"
              @click="editarTasques()"
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
import axios from "axios";

export default {
  components: { layout },
  name: "editarTasques",
  data() {
    return {
      nom: "",
      descripcio: "",
      id_usuari: "",
      prioritat: "",
      estat: "pendent",
      comentaris_tecnics: "",
      loading: false,
      desserts:[],
      userRole: sessionStorage.rol,
      rules: [(v) => !!v || "Camp requerit"],
    };
  },
  methods: {
    editarTasques() {
      axios
        .post("http://localhost/api/editartasques/", {
          token: sessionStorage.tokenusuari,
          nom: this.nom,
          descripcio: this.descripcio,
          id_usuari: this.id_usuari,
          prioritat: this.prioritat,
          estat: this.estat,
          comentaris_tecnics: this.comentaris_tecnics,
        })
        .then((response) => {
          this.$router.push("/tasques");
        })
        .catch((error) => {
          console.error(error); // manejar el error de la solicitud
        });
    },
  },
  mounted() { // este hook se ejecuta cuando el componente es montado
    axios.post("http://localhost/api/llistarunatasca/", {
        token: sessionStorage.tokenusuari,
        id:sessionStorage.idTasca
      })
      .then(resultat => {
        // pillem amb el session storage els valors de la id i el rol
        //Així els tenim a mà en tot el codi
        console.log(resultat.data.tasca)
        this.desserts = resultat.data.tasca;

      })
      .catch(error => {
        console.log(error);
      });
  }

};
</script>

<style src="@/styles/settings.scss"></style>
