<template>
  <v-card>
    <v-layout>
      <layout> </layout>
      <v-main>
        <v-container class="container">
          <div class="titul">
            <h1>Tasques</h1>
          </div>
          <v-table fixed-header height="700px" show-expand>
            <thead>
              <tr>
                <th class="text-left">Tasca</th>
                <th class="text-left">Prioritat</th>
                <th class="text-left">Estats</th>
                <th class="text-left">Usuari asignat</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in desserts" :key="item.id">
                <td>{{ item.tasques }}</td>
                <td>{{ item.prioritat }}</td>
                <td>{{ item.estats }}</td>
                <td>{{ item.usuariAsignat }}</td>
                <div class="buttonEditar">
                  <v-btn icon="mdi-pen" color="info" @click="this.$router.push("crearTasques")"></v-btn>
                </div>
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
import taulaTasques from "@/components/taulaTasques.vue";

export default {
  components: { layout, taulaTasques },
  name: "tasques",
  data() {
    return {
      expanded: [],
      singleExpand: false,
      desserts: [
        {
          id: 1,
          tasques: "Montar ordinador",
          prioritat: 9,
          estats: "Pendent",
          usuariAsignat: "Joel De Palol Sanjuan",
        },
        {
          id: 2,
          tasques: "Canviar CPU",
          prioritat: 5,
          estats: "Pendent",
          usuariAsignat: "Arnau Soler Serra",
        },
      ],
    };
  },
};
</script>

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
