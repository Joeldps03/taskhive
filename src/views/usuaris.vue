<template>
  <v-card>
    <v-layout>
      <layout> </layout>
      <v-main>
        <v-container class="container2">
          <div class="titul">
            <h1>Usuaris</h1>
          </div>
          <v-table fixed-header height="500px" show-expand>
            <thead>
              <tr>
                <th class="text-left">Correu</th>
                <th class="text-left">Nom</th>
                <th class="text-left">Contraseya</th>
                <th class="text-left">Rol</th>
                <th class="text-left"></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in desserts" :key="item.id">
                <td>{{ item.email }}</td>
                <td>{{ item.nom }}</td>
                <td>{{ item.contrasenya }}</td>
                <td>{{ item.rol }}</td>
                <div class="buttonEditar">
          
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
  components: { layout },
  name: "usuaris",
  data() {
    return {
      expanded: [],
      singleExpand: false,
      desserts: [] 
      
    };
  },
  methods: {
  },
  mounted(){
    axios.post("http://localhost/api/usuari/", {
        token: sessionStorage.tokenusuari
      })
      .then(resultat => {
        this.desserts = resultat.data.usuaris;
        console.log(resultat.data.usuaris)
      })
      .catch(error => {
        console.log(error);
      });
  }
};
</script>

<style src="@/styles/settings.scss">
</style>