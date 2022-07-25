<template>
  <layout
    type="Doctor"
    :title="'Patients/ ' + patient.first_name + ' ' + patient.last_name"
    :user="user_type"
  >
    <notification color="info" :icon="mdiMonitorCellphone">
      <b>Responsive table.</b> Collapses on mobile
    </notification>
    <div class="flex justify-end">
      <Link :href="route('patients.edit', patient.key)">
        <jb-button
          :outline="darkMode"
          small
          color="info"
          label="Edit"
          class="my-4"
        />
      </Link>
    </div>
    <div class="flex justify-end">
      <Link :href="route('reports.create', patient)">
        <jb-button
          :outline="darkMode"
          small
          color="info"
          label="Add Report"
          class="my-4"
        />
      </Link>
    </div>
    <card-component>
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

    <card-component :icon="mdiTicket" title="Reports" has-table>
      <base-table
        ><thead>
          <tr>
            <th>Ticket Number</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Department</th>
            <th>Reason</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>test</td>
            <td>tests</td>
            <td>test</td>
            <td>test</td>
            <td>test</td>
            <td>test</td>
            <td>
              <div class="flex justify-end mr-1">
                <Link :href="route('tickets.edit', [])">
                  <jb-button
                    :outline="darkMode"
                    color="success"
                    label="Change Status"
                    class="mr-4"
                  />
                </Link>
                <jb-button
                  :outline="darkMode"
                  color="danger"
                  label="Delete"
                  s
                />
              </div>
            </td>

            <!-- <td>
              <div class="flex justify-end mr-1">
                <Link :href="route('doctors.edit', doctor.key)">
                  <jb-button
                    :outline="darkMode"
                    color="success"
                    label="Edit"
                    class="mr-4"
                  />
                </Link>
                <jb-button
                  :outline="darkMode"
                  color="danger"
                  label="Delete"
                  @click="deleteDoctor(doctor.key)"
                />
              </div>
            </td> -->
          </tr>
        </tbody></base-table
      >
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
import BaseTable from "@/components/BaseTable.vue"
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
    user_type: String
  },
  methods: {}
}
</script>
