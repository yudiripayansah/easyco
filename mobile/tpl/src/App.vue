<template>
  <v-app class="orange lighten-5">
    <div id="baik-tpl" class="d-flex mx-auto orange lighten-5 pb-12">
      <!-- <v-app-bar elevation="4" absolute color="orange lighten-1" class="text-center d-flex justify-content-center">
        <v-toolbar-title class="white--text d-flex align-center">
          <img src="./assets/logo-baik.png" class="bt-logo me-2"/>
          <b>KSPPS BAIK TPL</b>
        </v-toolbar-title>
      </v-app-bar> -->
      <v-main class="bt-content pb-12">
        <router-view/>
      </v-main>
      <Navigation/>
    </div>
  </v-app>
</template>

<script>
import Navigation from './components/Navigation.vue'
export default {
  name: 'App',
  components: {
    Navigation
  },
  data: () => ({
    
  }),
  mounted(){
    
  }
};
</script>
