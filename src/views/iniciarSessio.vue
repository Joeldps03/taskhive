<template>
  <div id="fonsDePantalla">
    <v-form v-model="form" @submit.prevent="onSubmit" class="divCentre">
      <v-col cols="20">
        <v-text-field
          v-model="email"
          id="email"
          :readonly="loading"
          clearable
          :rules="[rules.required, rules.email]"
          name="correu"
          label="Correu"
          bg-color="white"
          class="input-group--focused"
          color="blue"
        ></v-text-field>

        <br />

        <v-text-field
          v-model="password"
          :readonly="loading"
          id="password"
          clearable
          :append-icon="mostrar ? 'mdi-eye' : 'mdi-eye-off'"
          :rules="[rules.required, rules.min]"
          :type="mostrar ? 'text' : 'password'"
          name="contrasenya"
          label="Contraseya"
          bg-color="white"
          class="input-group--focused"
          color="blue"
          @click:append="mostrar = !mostrar"
        ></v-text-field>

        <br />
        <br />

        <v-btn
          :loading="loading"
          color="black"
          size="large"
          type="submit"
          variant="outlined"
        >
          Iniciar Sessió
        </v-btn>
      </v-col>
    </v-form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      mostrar: true,
      rules: {
        required: (value) => !!value || "Obligatori.",
        min: (v) => v.length >= 8 || "Mínim 8 caràcters.",
        comprovarContrasenya: () =>
          `El correu electrònic i la contrasenya que heu introduït no coincideixen.`,
        email: (value) => {
          const pattern =
            /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          return pattern.test(value) || "Correu invalid.";
        },
      },
      email: null,
      password: null,
      loading: false,
    };
  },
  methods: {
    onSubmit() { 
      axios.get("http://localhost/api/login/",{
        email: this.email,
        password: this.password
      })
        //pillem el valor de l'api i ho introduim dintre de resposta
      .then(resultat => {
        // si la respuesta es satisfactoria, redirigimos a la página de inicio
        this.$router.push("/tasques");
      })
      .catch(error => {
        // si hay un error, mostramos un mensaje de error
        this.message = 'Credencials invàlides, si us plau intenteu de nou.';
      });
    },  
  },
};
</script>

<style src="@/styles/settings.scss">
</style>

