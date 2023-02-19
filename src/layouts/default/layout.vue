<template>
  <v-app-bar color="#00A9E0" prominent>
    <v-col cols="3">
      <img
        src="@/assets/imatges/Logo_Sense_Fonts.png"
        style="width: 50px; height: 50px"
      />
    </v-col>
    
    <div class="imatgeNomSenser">
      <img
        src="@/assets/imatges/Nom_Sense_Fonts.png"
        style="width: 650px; height: 70px; margin-left: 100px;"
      />
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
    <div v-if="userRole === 'admin'">
        <v-list-item
          prepend-icon="mdi-file-document"
          title="Tasques"
          @click="redirectTasques()"
          active-color="blue"
          rounded="xl"
          color="blue"
        >
        </v-list-item>
      
      
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
    </div>

    <div v-if="userRole === 'tecnic'">
        <v-list-item
          prepend-icon="mdi-file-document"
          title="Tasques"
          @click="redirectTasques()"
          active-color="blue"
          rounded="xl"
          color="blue"
        >
        </v-list-item>
        <v-list-item
        prepend-icon="mdi-logout"
        title="Tencar Sessió"
        @click="tencarSessio()"
        active-color="blue"
        rounded="xl"
      ></v-list-item>
    </div>

    <div v-if="userRole === 'gestor'">
      
      <v-list-item
          prepend-icon="mdi-file-document"
          title="Tasques"
          @click="redirectTasques()"
          active-color="blue"
          rounded="xl"
          color="blue"
        >
        </v-list-item>
      
      
      <v-list-item
        prepend-icon="mdi-file-document-plus"
        title="Crear Tasques"
        @click="redirectCrearTasques()"
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

    </div>



    </v-list>
  </v-navigation-drawer>

  <v-app-bar color="#00A9E0" prominent flat height="48" location="bottom">
    <v-col class="footer">
      Task Hive © 2023 Autors: Joel De Palol Sanjuan i Arnau Soler Serra
    </v-col>
  </v-app-bar>
</template>

<script>
export default {
  name: "layout",
  data() {
    return {
      userRole: sessionStorage.rol,
      reloadPage: true
    };
  },
  methods: {
    redirectTasques() {
      this.$router.push("/tasques");
    },

    redirectCrearTasques() {
      this.$router.push("/crearTasques");
    },

    redirectUsuaris() {
      this.$router.push("/usuaris");
    },

    redirectCrearUsuaris() {
      this.$router.push("/crearUsuaris");
    },

    tencarSessio() {
      this.$router.push("/iniciarSessio");
    },
 
  },
 
 
  watch: {
    group() {
      this.drawer = false;
    },
  },
};
</script>

<style src="@/styles/settings.scss">
</style>