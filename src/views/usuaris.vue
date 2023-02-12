<template>
  <v-card>
    <v-layout>
      <layout> </layout>
      <v-main>
        <v-container class="container">
          <div class="titul">
            <h1>Usuaris</h1>
          </div>
          <v-table fixed-header height="700px" show-expand>
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
                <td>{{ item.correu }}</td>
                <td>{{ item.nom }}</td>
                <td>{{ item.contrasenya }}</td>
                <td>{{ item.rol }}</td>
                <div class="buttonEditar">
                <v-btn icon="mdi-pen" color="info"></v-btn>
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

export default {
  components: { layout },
  name: "usuaris",
  data() {
    return {
      expanded: [],
      singleExpand: false,
      desserts: [
        {
          id: 1,
          correu: "joeldepalol@gmail.com",
          nom: "Joel De Palol Sanjuan",
          contrasenya: "daw1234",
          rol: "admin",
        },
        {
          id: 2,
          correu: "arnausoler@gmail.com",
          nom: "Arnau Soler Serra",
          contrasenya: "daw4321",
          rol: "admin",
        },
        {
          id: 2,
          correu: "arnausoler@gmail.com",
          nom: "Arnau Soler Serra",
          contrasenya: "daw4321",
          rol: "admin",
        },
        {
          id: 2,
          correu: "arnausoler@gmail.com",
          nom: "Arnau Soler Serra",
          contrasenya: "daw4321",
          rol: "admin",
        },
        {
          id: 2,
          correu: "arnausoler@gmail.com",
          nom: "Arnau Soler Serra",
          contrasenya: "daw4321",
          rol: "admin",
        },
        {
          id: 2,
          correu: "arnausoler@gmail.com",
          nom: "Arnau Soler Serra",
          contrasenya: "daw4321",
          rol: "admin",
        },
        {
          id: 2,
          correu: "arnausoler@gmail.com",
          nom: "Arnau Soler Serra",
          contrasenya: "daw4321",
          rol: "admin",
        },
        {
          id: 2,
          correu: "arnausoler@gmail.com",
          nom: "Arnau Soler Serra",
          contrasenya: "daw4321",
          rol: "admin",
        },
        {
          id: 2,
          correu: "arnausoler@gmail.com",
          nom: "Arnau Soler Serra",
          contrasenya: "daw4321",
          rol: "admin",
        },
        {
          id: 2,
          correu: "arnausoler@gmail.com",
          nom: "Arnau Soler Serra",
          contrasenya: "daw4321",
          rol: "admin",
        },
        {
          id: 2,
          correu: "arnausoler@gmail.com",
          nom: "Arnau Soler Serra",
          contrasenya: "daw4321",
          rol: "admin",
        },
        {
          id: 2,
          correu: "arnausoler@gmail.com",
          nom: "Arnau Soler Serra",
          contrasenya: "daw4321",
          rol: "admin",
        },
        {
          id: 2,
          correu: "arnausoler@gmail.com",
          nom: "Arnau Soler Serra",
          contrasenya: "daw4321",
          rol: "admin",
        },
        {
          id: 2,
          correu: "arnausoler@gmail.com",
          nom: "Arnau Soler Serra",
          contrasenya: "daw4321",
          rol: "admin",
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