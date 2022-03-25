<template>
  <v-col cols="12" sm="12" md="12">
    <v-card>
      <v-card-title></v-card-title>
      <v-card-text>
        <v-row dense>
          <v-col cols="12" sm="12" md="12">
            <line-chart :chart-data="getGraficoDiario" :options="chartOptions" :height="500" />
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>
  </v-col>
</template>

<script>
import LineChart from '../../plugins/LineChart'
import { mapGetters } from 'vuex'

export default {
  name: 'PanelEjecucionDiaria',
  components: {
    LineChart
  },
  data() {
    return {
      chartOptions: {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
          labels: { boxWidth: 5 }
        },
        scales: {
          yAxes: [
            {
              ticks: {
                callback: function(value) {
                  return (
                    'S/ ' +
                    Math.round(value)
                      .toString()
                      .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
                  )
                }
              }
            }
          ]
        },
        tooltips: {
          callbacks: {
            label: function(tooltipItem, data) {
              let label = data.datasets[tooltipItem.datasetIndex].label || '';
              if (label) {
                label += ': S/ ';
              }
              label += tooltipItem.yLabel.toFixed(2)
                .replace(/\B(?=(\d{3})+(?!\d))/g, ',');
              return label;
            }
          }
        }
      }
    }
  },
  computed: {
    ...mapGetters(['getGraficoDiario', 'formatDecimal'])
  }
}
</script>

<style scoped></style>
