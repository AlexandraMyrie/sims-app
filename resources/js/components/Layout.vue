<template>
  <Head :title="title" />
  <app :user="user">
    <title-bar :type="type" :page="title" />
    <hero-bar :button="button" :labelIcon="mdiTicket" :label="label" :url="url"
      >{{ mode }} {{ title }}</hero-bar
    >
    <main-section>
      <slot />
      <flash-message />
    </main-section>
  </app>
</template>

<script setup>
import { Head } from "@inertiajs/inertia-vue3"
import App from "@/layouts/App.vue"
import { computed, ref, onMounted } from "vue"
import { useMainStore } from "@/stores/main"
import {
  mdiBone,
  mdiTicket,
  mdiAccountMultiple,
  mdiCartOutline,
  mdiChartTimelineVariant,
  mdiFinance,
  mdiMonitorCellphone,
  mdiReload,
  mdiGithub,
  mdiChartPie
} from "@mdi/js"
import * as chartConfig from "@/components/Charts/chart.config.js"
import LineChart from "@/components/Charts/LineChart.vue"
import MainSection from "@/components/MainSection.vue"
import TitleBar from "@/components/TitleBar.vue"
import HeroBar from "@/components/HeroBar.vue"

import Notification from "@/components/Notification.vue"
import JbButton from "@/components/JbButton.vue"
import CardTransactionBar from "@/components/CardTransactionBar.vue"
import CardClientBar from "@/components/CardClientBar.vue"
import TitleSubBar from "@/components/TitleSubBar.vue"
import FlashMessage from "@/components/FlashMessage.vue"

defineProps({
  label: {
    type: String,
    default: null
  },
  user: {
    type: String,
    default: null
  },
  url: {
    type: String,
    default: null
  },
  button: {
    type: String,
    default: null
  },
  title: {
    type: String,
    default: null
  },
  mode: {
    type: String,
    default: null
  },

  type: {
    type: String,
    default: null
  }
})

const titleStack = ref(["Admin", "Create Doctor"])

const chartData = ref(null)

const fillChartData = () => {
  chartData.value = chartConfig.sampleChartData()
}

onMounted(() => {
  fillChartData()
})

const mainStore = useMainStore()

const clientBarItems = computed(() => mainStore.clients.slice(0, 3))

const transactionBarItems = computed(() => mainStore.history.slice(0, 3))

const darkMode = computed(() => mainStore.darkMode)
</script>
