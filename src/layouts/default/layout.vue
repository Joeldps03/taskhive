<template>
<!-- 
    <v-layout>
      <v-app-bar color="#00A9E0" prominent>
        <v-col cols="3">
          <img
            src="../assets/imatges/Logo_Sense_Fonts.png"
            style="width: 50px; height: 50px"
          />
        </v-col>
        <div class="buscador">
          <v-text-field
        :loading="loading"
        density="compact"
        variant="solo"
        label="Search templates"
        append-inner-icon="mdi-magnify"
        single-line
        hide-details
        @click:append-inner="onClick"
      ></v-text-field>
        </div>
              
      </v-app-bar>

      <v-navigation-drawer location="left" expand-on-hover rail>
        <v-list dense nav>
     
          <v-list-item
            prepend-icon="mdi-file-document"
            title="Tasques"
            @click="redirectTasques()"
            active-color="blue"
            rounded="xl"
          ></v-list-item>

          <v-list-item
            prepend-icon="mdi-file-document-plus"
            title="Crear Tasques"
            @click="redirectCrearTasques()"
            active-color="blue"
            rounded="xl"
          ></v-list-item>

          <v-list-item
            prepend-icon="mdi-account-multiple"
            title="Usuaris"
            @click="redirectUsuaris()"
            active-color="blue"
            rounded="xl"
          ></v-list-item>

          <v-list-item
            prepend-icon="mdi-account-multiple-plus"
            title="Crear Usuaris"
            @click="redirectCrearUsuaris()"
            active-color="blue"
            rounded="xl"
          ></v-list-item>


          <v-list-item
            prepend-icon="mdi-logout"
            title="Tencar Sessió"
            @click="tencarSessio()"
            active-color="blue"
            rounded="xl"
          ></v-list-item>

        </v-list>
      </v-navigation-drawer>
      <v-main style="height: 100%"></v-main>

      <v-app-bar
        height="48"
        location="bottom"
      >
        <v-footer  color="#00A9E0">
          <v-col class="text-center">
            Task Hive © 2023 Autors: Joel De Palol Sanjuan i Arnau Soler Serra
          </v-col>
        </v-footer>
      </v-app-bar>
    </v-layout> -->
     <v-card>
    <v-layout>

      <v-app-bar color="#00A9E0" prominent>
        <v-col cols="3">
          <img
            src="../assets/imatges/Logo_Sense_Fonts.png"
            style="width: 50px; height: 50px"
          />
        </v-col>
        <div class="buscador">
          <v-text-field
        :loading="loading"
        density="compact"
        variant="solo"
        label="Buscar ..."
        append-inner-icon="mdi-magnify"
        single-line
        hide-details
        @click:append-inner="onClick"
      ></v-text-field>
        </div>
              
      </v-app-bar>


      <v-navigation-drawer
        color="grey-darken-1"
        permanent
        width="200"
        location="left" 
        expand-on-hover 
        rail
      >
      <v-list dense nav>
     
          <v-list-item
            prepend-icon="mdi-file-document"
            title="Tasques"
            @click="redirectTasques()"
            active-color="blue"
            rounded="xl"
          ></v-list-item>

          <v-list-item
            prepend-icon="mdi-file-document-plus"
            title="Crear Tasques"
            @click="redirectCrearTasques()"
            active-color="blue"
            rounded="xl"
          ></v-list-item>

          <v-list-item
            prepend-icon="mdi-account-multiple"
            title="Usuaris"
            @click="redirectUsuaris()"
            active-color="blue"
            rounded="xl"
          ></v-list-item>

          <v-list-item
            prepend-icon="mdi-account-multiple-plus"
            title="Crear Usuaris"
            @click="redirectCrearUsuaris()"
            active-color="blue"
            rounded="xl"
          ></v-list-item>


          <v-list-item
            prepend-icon="mdi-logout"
            title="Tencar Sessió"
            @click="tencarSessio()"
            active-color="blue"
            rounded="xl"
          ></v-list-item>

        </v-list>
      
      </v-navigation-drawer>


      <v-navigation-drawer
        color="grey-lighten-1"
        location="right"
        permanent
        width="150"
      ></v-navigation-drawer>

      <v-app-bar
        color="grey-lighten-2"
        flat
        height="48"
        location="bottom"
      >
      <v-footer  color="#00A9E0">
          <v-col class="text-center">
            Task Hive © 2023 Autors: Joel De Palol Sanjuan i Arnau Soler Serra
          </v-col>
        </v-footer>
      
      </v-app-bar>

      <v-main>
        <v-container
          class="d-flex justify-center align-center text-h5"
          style="min-height: 300px;"
        >
          Content
        </v-container>
      </v-main>
    </v-layout>
  </v-card>
</template>

<script>
export default {
  name: "layout",
  data() {
    return {
      search: "",
    };
  },
  methods: {

    redirectTasques() {
      this.$router.push('tasques');
    },

    redirectCrearTasques() {
      this.$router.push('crearTasques');
    },

    redirectUsuaris() {
      this.$router.push('usuaris');
    },

    redirectCrearUsuaris() {
      this.$router.push('crearUsuaris');
    },

    tencarSessio() {
      this.$router.push('iniciarSessio');
    },


  },

  watch: {
    group() {
      this.drawer = false;
    },
  },
};
</script>

<style src="@/styles/settings.scss" >

</style>