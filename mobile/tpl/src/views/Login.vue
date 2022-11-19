<template>
  <div class="bt-login pa-10">
    <v-form @submit.prevent="doLogin" autocomplete="off">
      <v-row>
        <v-col xs=12 cols=12>
          <img src="../assets/logo-baik.png" class="bt-login-image mx-auto d-flex"/>
          <h2 class="text-center indigo--text lighten-5--text">LOGIN</h2>
        </v-col>
        <v-col xs=12 cols=12>
          <v-card elevation="3" class="pa-3 rounded-xl">
            <label class="ps-3 black--text">Username</label>
            <v-text-field 
              color="black"
              v-model="form.data.fa_code"  
              autocomplete="false" 
              hide-details
              flat
              solo
              dense
              prepend-inner-icon="mdi-account"
              name="fa_code"
              />
          </v-card>
        </v-col>
        <v-col xs=12 cols=12 v-show="form.showPassword">
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
            <router-link to="/forgot" class="indigo--text lighten-5">Lupa Password?</router-link>
          </p>
        </v-col>
      </v-row>
    </v-form>
    <Toast :show="alert.show" :msg="alert.msg"/>
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
          fa_code: 80020138,
          password: null,
          status: 0
        },
        showPassword: false,
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
      payload.append('fa_code', this.form.data.fa_code)
      try {
        if(this.form.data.status === 1){
          payload.append('password', this.form.data.password)
          payload.append('status', 0)
          let req = await services.authCheckPassword(payload)
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
        } else {
          let req = await services.authUsername(payload)
          const { data, msg, status } = req.data
          if(status){
            this.form.showPassword = true
            this.form.data.status = 1
            this.alert = {
              show: true,
              msg: msg
            }
          } else {
            this.alert = {
              show: true,
              msg: msg
            }
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
