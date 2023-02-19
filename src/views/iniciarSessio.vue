<template>
  <div id="fonsDePantalla">
    <v-form v-model="form" @submit.prevent="onSubmit" class="divCentre">
      <v-col cols="20">
        <v-text-field
          v-model="correu"
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
          v-model="contrasenya"
          :readonly="loading"
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
      from: false,
      correu: null,
      contrasenya: null,
      loading: false,
      message: "",
      token: sessionStorage.tokenconvidat
    };
  },
  methods: {
    onSubmit() { 
      // if(!(this.correu=="" && this.contrasenya=="")){
      axios.post("http://localhost/api/login/",{
        correu: this.correu,
        contrasenya: this.contrasenya,
        token: this.token
      })
        //pillem el valor de l'api i ho introduim dintre de resposta
      .then(resultat => {
        if(resultat.data){
          
          sessionStorage.setItem("tokenusuari", resultat.data.token)
          
          this.$router.push("/tasques");

          
        }        
      })
      .catch(error => {
        // si hay un error, mostramos un mensaje de error
        this.message = 'Credencials invàlides, si us plau intenteu de nou.';
      });
      // }
    },  
  },
};
</script>

<style src="@/styles/settings.scss">
</style>

