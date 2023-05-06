<template>
  <v-snackbar
      v-model="sShow"
      :timeout="timeout"
    >
      {{ sMsg }}
    </v-snackbar>
</template>
<script>
export default {
  props: ['show', 'msg'],
  data(){
    return {
      timeout: 3000,
      sShow: this.show,
      sMsg: this.msg
    }
  }
}
</script>