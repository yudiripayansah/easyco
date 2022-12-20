<template>
  <div class="indigo lighten-1 px-5 py-3 justify-center align-items-center bt-navigation" :class="$route.path == '/login' ? 'd-none' : 'd-flex'">
    <router-link to="/home" class="d-flex justify-center align-center rounded-lg pa-1 mx-4" :class="($route.path == '/home') ? 'indigo darken-1' : 'indigo lighten-5 elevation-3'">
      <v-icon :color="($route.path == '/home') ? 'indigo lighten-5' : 'indigo darken-1'">
        mdi-home
      </v-icon>
    </router-link>
    <router-link to="/keanggotaan" class="d-flex justify-center align-center rounded-lg pa-1 mx-4" :class="($route.path == '/keanggotaan') ? 'indigo darken-1' : 'indigo lighten-5 elevation-3'">
      <v-icon :color="($route.path == '/keanggotaan') ? 'indigo lighten-5' : 'indigo darken-1'">
        mdi-account-group
      </v-icon>
    </router-link>
    <router-link to="/pembiayaan" class="d-flex justify-center align-center rounded-lg pa-1 mx-4" :class="($route.path == '/pembiayaan') ? 'indigo darken-1' : 'indigo lighten-5 elevation-3'">
      <v-icon :color="($route.path == '/pembiayaan') ? 'indigo lighten-5' : 'indigo darken-1'">
        mdi-cash-multiple
      </v-icon>
    </router-link>
    <!-- <router-link to="/pengumuman" class="d-flex justify-center align-center rounded-lg pa-1 mx-4" :class="($route.path == '/pengumuman') ? 'indigo darken-1' : 'indigo lighten-5 elevation-3'">
      <v-icon :color="($route.path == '/pengumuman') ? 'indigo lighten-5' : 'indigo darken-1'">
        mdi-bell
      </v-icon>
    </router-link> -->
    <router-link to="/tabungan" class="d-flex justify-center align-center rounded-lg pa-1 mx-4" :class="($route.path == '/tabungan') ? 'indigo darken-1' : 'indigo lighten-5 elevation-3'">
      <v-icon :color="($route.path == '/tabungan') ? 'indigo lighten-5' : 'indigo darken-1'">
        mdi-wallet
      </v-icon>
    </router-link>
  </div>
</template>
<script>
export default {
  mounted(){
    console.log(this.$route.path)
  }
}
</script>