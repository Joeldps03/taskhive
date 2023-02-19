<template>
  <v-card>
    <v-layout>
      <layout> </layout>
      <v-main>
        <v-container class="container2">
          <div class="titul">
            <h1>Tasques</h1>
          </div>
          <v-table fixed-header height="500px" show-expand>
            <thead>
              <tr>
                <th class="text-left">Tasca</th>
                <th class="text-left">Prioritat</th>
                <th class="text-left">Estats</th>
                <th class="text-left">Usuari asignat</th>
                <th class="text-left"></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in desserts" :key="item.id">
                <td>{{ item.nom }}</td>
                <td>{{ item.prioritat }}</td>
                <td>{{ item.estat }}</td>
                <td>{{ item.id_usuari }}</td>

                <div class="buttons">
                  <div class="buttonEditar">
                  
                  <v-btn 
                  icon="mdi-pen" 
                  color="info" 
                  @click="redirectEditarTasques(item.id)"
                  >
                  </v-btn>

                </div>
                </div>
              
              </tr>
            </tbody>
          </v-table>
        </v-container>
      </v-main>
    </v-layout>
  </v-card>
</template>

<script>
import layout from "@/layouts/default/layout.vue";
import axios from 'axios';
export default {
  components: { layout},
  name: "tasques",
  data() {
    return {
      expanded: [],
      singleExpand: false,
      desserts: [],
      rol: null,
      id: null,
      idtasca:null,
      token: sessionStorage.tokenusuari
    };
  },
  methods: {
    redirectEditarTasques(id) {
      
      sessionStorage.setItem("idTasca", id)
      this.$router.push("tasquesEditar/" + id);
    },
  },
  mounted() { 
    location.reload();
    // este hook se ejecuta cuando el componente es montado
    axios.post("http://localhost/api/tasques/", {
        token: this.token
      })
      .then(resultat => {
        // pillem amb el session storage els valors de la id i el rol
        //Així els tenim a mà en tot el codi
        this.desserts = resultat.data.tasques;
        sessionStorage.setItem("id", resultat.data.usuari.id);
        sessionStorage.setItem("rol", resultat.data.usuari.rol);
      })
      .catch(error => {
        console.log(error);
      });

      
  },
 

};
</script>

<style src="@/styles/settings.scss">
</style>
