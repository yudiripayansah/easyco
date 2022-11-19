<template>
  <div class="orange lighten-1 px-5 py-3 justify-center align-items-center bt-navigation" :class="$route.path == '/login' ? 'd-none' : 'd-flex'">
    <router-link to="/home" class="d-flex justify-center align-center rounded-lg pa-1 mx-4" :class="($route.path == '/home') ? 'orange darken-1' : 'orange lighten-5 elevation-3'">
      <v-icon :color="($route.path == '/home') ? 'orange lighten-5' : 'orange darken-1'">
        mdi-home
      </v-icon>
    </router-link>
    <router-link to="/anggota" class="d-flex justify-center align-center rounded-lg pa-1 mx-4" :class="($route.path == '/anggota') ? 'orange darken-1' : 'orange lighten-5 elevation-3'">
      <v-icon :color="($route.path == '/anggota') ? 'orange lighten-5' : 'orange darken-1'">
        mdi-account-group
      </v-icon>
    </router-link>
    <router-link to="/transaksi" class="d-flex justify-center align-center rounded-lg pa-1 mx-4" :class="($route.path == '/transaksi/dashboard') ? 'orange darken-1' : 'orange lighten-5 elevation-3'">
      <v-icon :color="($route.path == '/transaksi/dashboard') ? 'orange lighten-5' : 'orange darken-1'">
        mdi-gesture-double-tap
      </v-icon>
    </router-link>
    <!-- <router-link to="/pengumuman" class="d-flex justify-center align-center rounded-lg pa-1 mx-4" :class="($route.path == '/pengumuman') ? 'orange darken-1' : 'orange lighten-5 elevation-3'">
      <v-icon :color="($route.path == '/pengumuman') ? 'orange lighten-5' : 'orange darken-1'">
        mdi-bell
      </v-icon>
    </router-link> -->
    <router-link to="/profile" class="d-flex justify-center align-center rounded-lg pa-1 mx-4" :class="($route.path == '/profile') ? 'orange darken-1' : 'orange lighten-5 elevation-3'">
      <v-icon :color="($route.path == '/profile') ? 'orange lighten-5' : 'orange darken-1'">
        mdi-account
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