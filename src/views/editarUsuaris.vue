<template>
  <v-card>
    <v-layout>
      <layout> </layout>
      <v-main>
        <v-container class="container">
          <div class="titul">
            <h1>Editar usuari</h1>
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
              Editar
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