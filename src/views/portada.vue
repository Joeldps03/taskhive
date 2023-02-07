<template>
  <v-card>
    <v-layout>
      <v-app-bar color="#00A9E0" prominent>
        <v-col cols="3">
          <img
            src="../assets/imatges/Logo_Sense_Fonts.png"
            style="width: 50px; height: 50px"
          />
        </v-col>
      </v-app-bar>

      <v-navigation-drawer expand-on-hover rail>
        <v-list dense nav>
     
          <v-list-item
            prepend-icon="mdi-file-document"
            title="Tasques"
            @click="redirectTasques()"
            active-color="#00a9e0"
            rounded="xl"
          ></v-list-item>

          <v-list-item
            prepend-icon="mdi-file-document-plus"
            title="Crear Tasques"
            @click="redirectCrearTasques()"
            active-color="#00a9e0"
            rounded="xl"
          ></v-list-item>

          <v-list-item
            prepend-icon="mdi-account-multiple"
            title="Usuaris"
            @click="redirectUsuaris()"
            active-color="#00a9e0"
            rounded="xl"
          ></v-list-item>

          <v-list-item
            prepend-icon="mdi-account-multiple-plus"
            title="Crear Usuaris"
            @click="redirectCrearUsuaris()"
            active-color="#00a9e0"
            rounded="xl"
          ></v-list-item>


          <v-list-item
            prepend-icon="mdi-logout"
            title="Tencar Sessió"
            @click="tencarSessio()"
            active-color="#00a9e0"
            rounded="xl"
          ></v-list-item>

        </v-list>
      </v-navigation-drawer>
      <v-main style="height: 100%"></v-main>
    </v-layout>
  </v-card>
</template>

<script>
export default {
  name: "MyLayout",
  data() {
    return {
      search: "",
    };
  },
  methods: {
    submit() {
      console.log("Buscando: " + this.search);
    },

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



