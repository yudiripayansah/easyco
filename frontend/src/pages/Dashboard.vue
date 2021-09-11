<template>
<b-card title="Dashboard">
  <div class="row m-0">
    <!-- <div class="col-3">
      <div class="bg-light-info px-6 py-8 rounded-xl">
        <span class="svg-icon svg-icon-3x svg-icon-info d-block my-2">
          <inline-svg src="media/svg/icons/Design/Layers.svg" />
        </span>
        <router-link to="/pasien" class="text-info font-weight-bold font-size-h6 mt-2">
          <b>{{dashboard.pasien}}</b> Pasien
        </router-link>
      </div>
    </div>
    <div class="col-3">
      <div class="bg-light-success px-6 py-8 rounded-xl">
        <span class="svg-icon svg-icon-3x svg-icon-success d-block my-2">
          <inline-svg src="media/svg/icons/Communication/Urgent-mail.svg" />
        </span>
        <router-link to="/hasil-test" class="text-success font-weight-bold font-size-h6 mt-2">
          <b>{{dashboard.pcr}}</b> Hasil PCR
        </router-link>
      </div>
    </div>
    <div class="col-3">
      <div class="bg-light-warning px-6 py-8 rounded-xl">
        <span class="svg-icon svg-icon-3x svg-icon-warning d-block my-2">
          <inline-svg src="media/svg/icons/Communication/Urgent-mail.svg" />
        </span>
        <router-link to="/hasil-test-antigen" class="text-warning font-weight-bold font-size-h6 mt-2">
          <b>{{dashboard.antigen}}</b> Hasil Antigen
        </router-link>
      </div>
    </div>
    <div class="col-3">
      <div class="bg-light-danger px-6 py-8 rounded-xl">
        <span class="svg-icon svg-icon-3x svg-icon-danger d-block my-2">
          <inline-svg src="media/svg/icons/Communication/Urgent-mail.svg" />
        </span>
        <router-link to="/hasil-test-antibody" class="text-danger font-weight-bold font-size-h6 mt-2">
          <b>{{dashboard.antibody}}</b> Hasil Antibody
        </router-link>
      </div>
    </div> -->
  </div>
</b-card>
</template>

<script>
import axios from '@/core/plugins/axios'
export default {
  name: "dashboard",
  components: {

  },
  data() {
    return {
      dashboard: {
        pasien: 0,
        pcr: 0,
        antigen: 0,
        antibody: 0
      }
    }
  },
  mounted() {
    this.getDashboard()
  },
  methods: {
    getDashboard() {
      let url = '/dashboard'
      axios
        .post(url)
        .then((res) => {
          this.dashboard = res.data.data
        })
        .catch((e) => {
          this.notify('danger', 'Error', 'Internal server error')
        })
    },
    notify(type, title, msg) {
      this.$bvToast.toast(msg, {
        title: title,
        autoHideDelay: 5000,
        variant: type,
        toaster: 'b-toaster-bottom-right',
        appendToast: true
      })
    }
  }
};
</script>
