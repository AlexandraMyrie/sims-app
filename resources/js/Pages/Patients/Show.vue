<template>
  <layout
    type="Doctor"
    :title="'Patients/ ' + patient.first_name + ' ' + patient.last_name"
    :user="user_type"
    :current_user="current_user"
  >
    <notification color="info" :icon="mdiMonitorCellphone">
      <b>Responsive table.</b> Collapses on mobile
    </notification>
    <div class="flex justify-end">
      <Link :href="route('patients.edit', patient.key)">
        <jb-button
          v-if="user_type != 'admin'"
          :outline="darkMode"
          small
          color="info"
          label="Edit"
          class="my-4"
        />
      </Link>
    </div>

    <card-component title="General Information" class="mt-2">
      <div class="grid grid-cols-3 gap-4">
        <info-label title="First Name" :info="patient.first_name" />
        <info-label title="Last Name" :info="patient.first_name" />
        <info-label title="Middle Initial" :info="patient.middle_initial" />
        <info-label title="Gender" :info="patient.gender" />
        <info-label title="Email" :info="patient.email" />
        <info-label title="Contact Number" :info="patient.contact_number" />
        <info-label title="TRN" :info="patient.trn" />
        <info-label title="National ID" :info="patient.national_id" />
        <info-label
          title="Emergency Contact Name"
          :info="patient.emergency_name"
        />
        <info-label
          title="Emergency Contact Number"
          :info="patient.emergency_contact_number"
        />
      </div>
    </card-component>

    <div class="flex justify-end mt-12">
      <Link :href="route('reports.create', patient)">
        <jb-button
          v-if="user_type != 'admin'"
          :outline="darkMode"
          small
          color="info"
          label="Add Report"
          class="my-4"
        />
      </Link>
    </div>
    <card-component :icon="mdiTicket" title="Reports" has-table class="mt-2">
      <base-table
        ><thead>
          <tr>
            <th>Date</th>
            <th />
          </tr>
        </thead>
        <tbody>
          <tr v-for="report in reports" :key="report">
            <td>{{ report.date }}</td>
            <td>
              <div class="flex justify-end mr-1">
                <Link :href="route('reports.show', report.key)">
                  <jb-button
                    :outline="darkMode"
                    color="info"
                    label="View"
                    class="mr-4"
                  />
                </Link>

                <jb-button
                  :outline="darkMode"
                  color="danger"
                  label="Delete"
                  @click="deleteReport(report.key)"
                />
              </div>
            </td>
          </tr>
        </tbody>
      </base-table>
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
    patient: Object,
    user_type: String,
    reports: Object,
    current_user: Object
  },
  methods: {
    deleteReport(id) {
      Inertia.delete(route("reports.destroy", id))
    },

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
