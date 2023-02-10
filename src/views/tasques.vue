<template>
  <v-card>
    <v-layout>
      <layout> </layout>
      <v-main>
        <v-container class="container">
        
          <v-table fixed-header height="100%" show-expand>
            <thead>
              <tr>
                <th class="text-left">Tasca</th>
                <th class="text-left">Prioritat</th>
                <th class="text-left">Estats</th>
                <th class="text-left">Usuari asignat</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in desserts" :key="item.tasques">
                <td>{{ item.tasques }}</td>
                <td>{{ item.prioritat }}</td>
                <td>{{ item.estats }}</td>
                <td>{{ item.usuariAsignat }}</td>
              </tr>
            </tbody>
          </v-table>

          <taula-tasques> </taula-tasques>
          
        </v-container>
      </v-main>
    </v-layout>
  </v-card>
</template>

<script>
import layout from "@/layouts/default/layout.vue";
import taulaTasques from "@/components/taulaTasques.vue"

export default {
  components: { layout, taulaTasques },
  name: "tasques",
  data() {
    return {
      expanded: [],
      singleExpand: false,
      desserts: [
        {
          tasques: "Montar ordinador",
          prioritat: 9,
          estats: "Pendent",
          usuariAsignat: "Joel De Palol Sanjuan",
        },
      ],
    };
  },
};
</script>

<style>
.container{
  background-color: black;
  height: 718px;
  margin-top: 50px;


}
</style>
