<template>
  <div class="bt-login pa-10">
    <v-form @submit.prevent="doLogin" autocomplete="off">
      <v-row>
        <v-col xs=12 cols=12>
          <img src="../assets/logo-baik.png" class="bt-login-image mx-auto d-flex"/>
          <h2 class="text-center white--text">LOGIN</h2>
        </v-col>
        <v-col xs=12 cols=12>
          <v-card elevation="3" class="pa-3 rounded-xl">
            <label class="ps-3 black--text">Username</label>
            <v-text-field 
              color="black"
              v-model="form.data.nama_user"  
              autocomplete="false" 
              hide-details
              flat
              solo
              dense
              prepend-inner-icon="mdi-account"
              name="nama_user"
              />
          </v-card>
        </v-col>
        <v-col xs=12 cols=12>
          <v-card elevation="3" class="pa-3 rounded-xl">
            <label class="ps-3 black--text">Password</label>
            <v-text-field
              color="black"
              v-model="form.data.password"
              :type="(showPass) ? 'text': 'password'"
              autocomplete="false"
              hide-details
              flat
              solo
              dense
              prepend-inner-icon="mdi-lock"
              :append-icon="showPass ? 'mdi-eye' : 'mdi-eye-off'"
              @click:append="showPass = !showPass"/>
          </v-card>
        </v-col>
        <v-col xs=12 cols=12>
          <v-btn block class="indigo darken-1 white--text rounded-pill py-8 text-h6" type="submit">
            Masuk
            <template v-slot:loader>
              <span class="custom-loader" :loading="form.loading">
                <v-icon light>mdi-cached</v-icon>
              </span>
            </template>
          </v-btn>
          <p class="text-center mt-3">
            <router-link to="/forgot" class="white--text">Lupa Password?</router-link>
          </p>
        </v-col>
      </v-row>
    </v-form>
    <v-snackbar
      v-model="alert.show"
      :timeout="5000"
    >
      {{ alert.msg }}
    </v-snackbar>
  </div>
</template>

<script>
import Toast from '@/components/Toast'
import {
  mapGetters,
  mapActions
} from "vuex";
import services from '../services'
export default {
  name: 'Login',
  components: {
    Toast
  },
  data(){
    return {
      form: {
        data: {
          nama_user: 'ummar',
          password: 'easycoOk',
        },
        loading: false
      },
      showPass: false,
      alert: {
        show: false,
        msg: ''
      }
    }
  },
  computed: {
    ...mapGetters(['user'])
  },
  methods: {
    ...mapActions(['login']),
    async doLogin(){
      let payload = new FormData()
      payload.append('nama_user', this.form.data.nama_user)
      payload.append('password', this.form.data.password)
      try {
        let req = await services.authLogin(payload)
        let { data, msg, status, token  } = req.data
        if(status){
          data.token = token
          this.login(data)
          this.alert = {
            show: true,
            msg: msg
          }
          this.$router.push('/').catch(()=>{});
        } else {
          this.alert = {
            show: true,
            msg: msg
          }
        }
      } catch (error) {
        this.alert = {
          show: true,
          msg: error
        }
      }
    }
  }
}
</script>
