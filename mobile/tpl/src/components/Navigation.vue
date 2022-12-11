<template>
  <div class="indigo lighten-1 px-5 py-3 justify-center align-items-center bt-navigation" :class="$route.path == '/login' ? 'd-none' : 'd-flex'">
    <router-link to="/home" class="d-flex justify-center align-center rounded-lg pa-1 mx-4" :class="($route.path == '/home') ? 'indigo darken-1' : 'indigo lighten-5 elevation-3'">
      <v-icon :color="($route.path == '/home') ? 'indigo lighten-5' : 'indigo darken-1'">
        mdi-home
      </v-icon>
    </router-link>
    <router-link to="/anggota" class="d-flex justify-center align-center rounded-lg pa-1 mx-4" :class="($route.path == '/anggota') ? 'indigo darken-1' : 'indigo lighten-5 elevation-3'">
      <v-icon :color="($route.path == '/anggota') ? 'indigo lighten-5' : 'indigo darken-1'">
        mdi-account-group
      </v-icon>
    </router-link>
    <router-link to="/transaksi" class="d-flex justify-center align-center rounded-lg pa-1 mx-4" :class="($route.path == '/transaksi/dashboard') ? 'indigo darken-1' : 'indigo lighten-5 elevation-3'">
      <v-icon :color="($route.path == '/transaksi/dashboard') ? 'indigo lighten-5' : 'indigo darken-1'">
        mdi-gesture-double-tap
      </v-icon>
    </router-link>
    <!-- <router-link to="/pengumuman" class="d-flex justify-center align-center rounded-lg pa-1 mx-4" :class="($route.path == '/pengumuman') ? 'indigo darken-1' : 'indigo lighten-5 elevation-3'">
      <v-icon :color="($route.path == '/pengumuman') ? 'indigo lighten-5' : 'indigo darken-1'">
        mdi-bell
      </v-icon>
    </router-link> -->
    <router-link to="/profile" class="d-flex justify-center align-center rounded-lg pa-1 mx-4" :class="($route.path == '/profile') ? 'indigo darken-1' : 'indigo lighten-5 elevation-3'">
      <v-icon :color="($route.path == '/profile') ? 'indigo lighten-5' : 'indigo darken-1'">
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