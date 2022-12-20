<template>
    <div class="bt-transaksi pa-5">
        <h6 class="text-h5 font-weight-bold indigo--text text--lighten-1 d-flex align-center">
            <div class="rounded-pill indigo lighten-1 me-2 px-2 d-flex align-center justify-center py-2 elevation-3">
                <v-icon small color="white">mdi-account-group</v-icon>
            </div>
            Keanggotaan
        </h6>
        <div class="d-flex flex-wrap justify-center mt-5">
            <router-link to="/keanggotaan"
                class="d-flex flex-column elevation-3 pa-3 indigo lighten-1 rounded-lg justify-center align-center mb-3 mx-1 bt-btn-transaksi">
                <v-icon color="indigo darken-3">
                    mdi-account-multiple-check
                </v-icon>
                <span class="text-caption text-center indigo--text text--lighten-5 font-weight-bold mt-1">Registrasi
                    Calon Anggota</span>
            </router-link>
        </div>
        <div class="d-flex flex-wrap justify-center mt-5">
            <router-link to="/keanggotaan"
                class="d-flex flex-column elevation-3 pa-3 indigo lighten-1 rounded-lg justify-center align-center mb-3 mx-1 bt-btn-transaksi">
                <v-icon color="indigo darken-3">
                    mdi-account-multiple-minus
                </v-icon>
                <span class="text-caption text-center indigo--text text--lighten-5 font-weight-bold mt-1">Registrasi
                    Anggota Keluar</span>
            </router-link>
        </div>
    </div>
</template>
  
<script>
export default {
    name: 'Keangotaan'
}
</script>
  