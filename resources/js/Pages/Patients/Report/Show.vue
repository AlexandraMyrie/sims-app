<template>
  <layout
    type="Doctor"
    title="Patient Report"
    :user="user_type"
    :current_user="current_user"
  >
    <card-component title="Report Information" class="mt-2">
      <div class="grid grid-cols-1 gap-4">
        <info-label title="Date of Visit" :info="report.date" />
        <info-label title="Comments" :info="report.diagnosis" />
      </div>
    </card-component>
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
import BaseTable from "@/components/Basetable.vue"
import Notification from "@/components/Notification.vue"
import JbButton from "@/components/JbButton.vue"
import Layout from "@/components/Layout.vue"
import BaseInput from "@/components/BaseInput.vue"
import TitleSubBar from "@/components/TitleSubBar.vue"
import InfoLabel from "@/components/InfoLabel.vue"
import { Inertia } from "@inertiajs/inertia"
import { Link } from "@inertiajs/inertia-vue3"

export default {
  components: {
    CardWidget,
    CardComponent,
    BaseTable,
    Notification,
    JbButton,
    Layout,
    BaseInput,
    TitleSubBar,
    InfoLabel,
    Link
  },
  props: {
    user_type: String,
    report: Object,
    current_user: Object
  },
  methods: {
    showReport(id, patient) {
      Inertia.visit("reports/show", {
        method: "get",
        data: { id: id, patient: patient }
      })
    },

    test(id) {
      return id
    }
  }
}
</script>
