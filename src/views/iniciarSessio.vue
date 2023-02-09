<template>
  <div id="pantallaCarga">


     <v-card class="divCentre">
      <v-form
        v-model="form"
        @submit.prevent="onSubmit"
      >

      <v-col
          cols="12"
          sm="6"
        > 

                <v-text-field
          v-model="email"
          :readonly="loading"
          :rules="[required]"
          class="mb-2"
          clearable
          label="Email"
        ></v-text-field>
          
        </v-col>

        <v-col
          cols="12"
          sm="6"
        > 

        <v-text-field
            :append-icon="mostrar ? 'mdi-eye' : 'mdi-eye-off'"
            :parametres="[parametres.obligatori, parametres.minim]"
            :type="mostrar ? 'text' : 'password'"
            name="contrasenya"
            label="Contraseya"
            bg-color="white"
            color="blue"
            hint="Com a mínim 8 caràcters"
            
            @click:append="mostrar = !mostrar"
          ></v-text-field>

        <br>
        </v-col>
        <v-btn
          :disabled="!form"
          :loading="loading"
          block
          color="success"
          size="large"
          type="submit"
          variant="elevated"
        >
          Sign In
        </v-btn>
      </v-form>
    </v-card>

    <!-- <div class="divCentre"> -->
      
       <!-- <v-col
          cols="12"
          sm="6"
        > -->
          
        <!-- </v-col> -->
      
      
    <!-- </div> -->

  </div>

  
</template>

<script>
  export default {
    data () {
      return {
        mostrar: true,
        contrasenya: 'Contrasenya',
        parametres: {
          obligatori: value => !!value || 'Obligatori.',
          minim: v => v.length >= 8 || 'Mínim 8 caràcters.',
          comprovarContrasenya: () => (`El correu electrònic i la contrasenya que heu introduït no coincideixen.`),
        },
      }
    },
  }
</script>

<style>
#pantallaCarga {
  background: url("../assets/imatges/IniciSessio.png");
  width: 100%;
  height: 100%;
  position: fixed;
  background-size: 100% 100%;
}
.divCentre {
  position: absolute;
  padding: 20px;
  text-align: center;
  top: 52%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 1200px;
  height: 600px;
  background-color: black;
  text-align: center;

  border-radius: 50px;
  
  
  
}
</style>