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
                <td>{{ item.tasques }}</td>
                <td>{{ item.prioritat }}</td>
                <td>{{ item.estats }}</td>
                <td>{{ item.usuariAsignat }}</td>
                <div class="buttonEditar">
                  
                  <v-btn 
                  icon="mdi-pen" 
                  color="info" 
                  @click="redirectEditarTasques(item.id)"
                  >
                  </v-btn>

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
      
    };
  },
  methods: {
    redirectEditarTasques(id) {
      this.$router.push("tasquesEditar/" + id);
    },
    fetchTasques() { // función que realiza la petición a la API
      axios.get("localhost/taskhive/api/tasques")
        .then(response => {
          this.desserts = response.data;
          console.log(response.data); // aquí guardamos los datos de las tareas en la variable desserts
        })
        .catch(error => {
          console.log(error);
        });
    },
    mounted() { // este hook se ejecuta cuando el componente es montado
    this.fetchTasques(); // llamamos a la función fetchTasques para obtener los datos de la API
  }
  }

};
</script>

<style src="@/styles/settings.scss">
</style>
