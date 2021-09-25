<template>
<b-card :title="$route.name">
  <b-row class="m-0">
    <b-col sm=6>
      
    </b-col>
    <b-col sm=6>
      <b-button-group>
        <b-button variant="success">Export</b-button>
      </b-button-group>
    </b-col>
  </b-row>
</b-card>
</template>

<script>
import axios from '@/core/plugins/axios'
export default {
  name: "PengajuanPembiayaan",
  components: {

  },
  data() {
    return {
      table: {
        columns: [
          {
            key: 'id',
            label: '#',
            sortable: true,
            thClass: 'text-center w-5',
            tdClass: 'text-center'
          },
        ],
      }
    }
  },
  mounted() {
  },
  methods: {
    
  }
};
</script>
