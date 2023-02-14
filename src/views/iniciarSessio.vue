<template>
  <div id="fonsDePantalla">
    <v-form v-model="form" @submit.prevent="onSubmit" class="divCentre">
      <v-col cols="20">
        <v-text-field
          v-model="email"
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
export default {
  data() {
    return {
      mostrar: true,
      rules: {
        rules: (value) => !!value || "Obligatori.",
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
    onSubmit() {    },
  },
};
</script>

<style src="@/styles/settings.scss">
</style>

