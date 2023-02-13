<template>
  <v-card>
    <v-layout>
      <layout> </layout>
      <v-main>
        <v-container class="container">
          <div class="titul">
            <h1>Crear tasca</h1>
          </div>

          <div class="divAltres">
            <h3>Tasca</h3>

            <v-col cols="100">
              <v-text-field clearable :rules="rules"></v-text-field>
            </v-col>
          </div>
          
          <div class="divEPU">
            <div class="divCentreTasca">
            <h3>Estat</h3>

            <v-col cols="100" >
              <v-text-field clearable :rules="rules"></v-text-field>
            </v-col>
            </div>

            <div class="divCentreTasca">
            <h3>Prioritat</h3>

            <v-col cols="100">
              <v-text-field clearable :rules="rules"></v-text-field>
            </v-col>
            </div>

            <div class="divCentreTasca">
              <h3>Usuari asignat</h3>

              <v-col cols="100">
                <v-text-field clearable :rules="rules"></v-text-field>
              </v-col>
            </div>
          </div>

          <div class="divEPU">
            <div class="divCentreTasca">
              <h3>Descripció</h3>

              <v-col cols="15">
                <v-textarea clearable ></v-textarea>
              </v-col>
            </div>

            <div class="divCentreTasca">
              <h3>Comentari</h3>

              <v-col cols="15">
                <v-textarea clearable ></v-textarea>
              </v-col>
            </div>
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
  name: "crearTasques",
}
</script>

<style src="@/styles/settings.scss">
</style>