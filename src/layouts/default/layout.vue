<template>
<!-- Barra superior -->
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
        style="width: 650px; height: 70px; margin-left: 100px"
      />
    </div>
  </v-app-bar>

<!-- Barra lateral esquerra -->
  <v-navigation-drawer
    color="grey-darken-1"
    permanent
    width="200"
    location="left"
    expand-on-hover
    rail
  >
  <!-- Si es admin es mostrarant els botons seguents -->
    <v-list dense nav>
      <div v-if="rol === 'admin'">
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

      <!-- Si es tecnic es mostrarant els botons seguents -->
      <div v-if="rol === 'tecnic'">
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

      <!-- Si es gestor es mostrarant els botons seguents -->
      <div v-if="rol === 'gestor'">
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

<!-- footer -->
  <v-app-bar color="#00A9E0" prominent flat height="48" location="bottom">
    <v-col class="footer">
      Task Hive © 2023 Autors: Joel De Palol Sanjuan i Arnau Soler Serra
    </v-col>
  </v-app-bar>
</template>

<script>
export default {
  name: "layout",
  props: ["rol"],
  data() {
    return {
      //Agafem el rol del session storage
     
    };
  },
  methods: {
    //Metodes de push a roter
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
};
</script>

<style src="@/styles/settings.scss"></style>
