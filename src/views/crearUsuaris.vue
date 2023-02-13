<template>
  <v-card>
    <v-layout>
      <layout> </layout>
      <v-main>
        <v-container class="container">
          <div class="titul">
            <h1>Crear usuari</h1>
          </div>

          <div class="divAltres">
            <h3>Nom</h3>

            <v-col cols="6">
              <v-text-field clearable :rules="rules"></v-text-field>
            </v-col>
          </div>

          <div class="divAltres">
          <h3>Correu</h3>

          <v-col cols="10">
            <v-text-field clearable :rules="rules"></v-text-field>
          </v-col>
          </div>

          <div class="divAltres">
          <h3>Contrasenya</h3>

          <v-col cols="10">
            <v-text-field clearable :rules="rules"></v-text-field>
          </v-col>
          </div>

          <div class="divAltres">
            <h3>Rol</h3>

            <v-col cols="6">
              <v-text-field clearable :rules="rules"></v-text-field>
            </v-col>
          </div>

          <div class="buttonEditar2">
            <v-btn
              :loading="loading"
              color="blue"
              size="large"
              type="submit"
              variant="outlined"
            >
              Crear
            </v-btn>
          </div>
        </v-container>
      </v-main>
    </v-layout>
  </v-card>
</template>
<script>
import layout from "@/layouts/default/layout.vue";

export default {
  components: { layout },
  name: "editarUsuaris",
};
</script>

<style src="@/styles/settings.scss">

</style>