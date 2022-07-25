<template>
  <layout
    type="Admin"
    title="Departments"
    button="add"
    url="departments/create"
    label="Add Department"
    :user="user_type"
    :current_user="current_user"
  >
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 mb-6">
      <div v-for="department in departments" :key="department">
        <i class="fas fa-abacus"></i>
        <card-widget
          :trend-type="department.status"
          color="text-blue-500"
          :number="department.doctors_count"
          prefix=""
          :label="department.name"
          :id="department.key"
        />
      </div>
    </div>
  </layout>
</template>

<script>
import * as chartConfig from "@/components/Charts/chart.config.js"
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
import CardWidget from "@/components/CardWidget.vue"
import CardComponent from "@/components/CardComponent.vue"

import Notification from "@/components/Notification.vue"
import JbButton from "@/components/JbButton.vue"
import Layout from "@/components/Layout.vue"
import TitleSubBar from "@/components/TitleSubBar.vue"

import { computed } from "vue"
const darkMode = computed(() => mainStore.darkMode)

export default {
  components: {
    CardWidget,
    CardComponent,

    Notification,
    JbButton,
    Layout,
    TitleSubBar
  },
  props: {
    departments: Object,
    user_type: String,
    current_user: Object
  }
}
</script>
