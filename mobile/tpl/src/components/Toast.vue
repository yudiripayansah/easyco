<template>
  <v-snackbar
      v-model="show"
      :timeout="timeout"
    >
      {{ msg }}
    </v-snackbar>
</template>
<script>
export default {
  props: ['show', 'msg'],
  data(){
    return {
      timeout: 3000
    }
  }
}
</script>