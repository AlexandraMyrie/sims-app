<template>
  <layout
    type="Admin"
    title="Doctors"
    button="add"
    url="doctors/create"
    label="Add Doctor"
    :user="user_type"
  >
    <notification color="info" :icon="mdiMonitorCellphone">
      <b>Responsive table.</b> Collapses on mobile
    </notification>

    <card-component :icon="mdiTicket" title="Doctors" has-table>
      <base-table
        ><thead>
          <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Middle Initial</th>
            <th>Department</th>
            <th />
          </tr>
        </thead>
        <tbody>
          <tr v-for="doctor in doctors" :key="doctor">
            <td>{{ doctor.first_name }}</td>
            <td>{{ doctor.last_name }}</td>
            <td>{{ doctor.middle_initial }}</td>
            <td>{{ departmentCheck(doctor.department) }}</td>

            <td>
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
            </td>
          </tr></tbody
      ></base-table>
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
import TitleSubBar from "@/components/TitleSubBar.vue"
import { Link } from "@inertiajs/inertia-vue3"
import { Inertia } from "@inertiajs/inertia"

export default {
  components: {
    CardWidget,
    CardComponent,
    BaseTable,
    Notification,
    JbButton,
    Layout,
    TitleSubBar,
    Link
  },
  props: {
    doctors: Object,
    departments: Array,
    user_type: String
  },
  methods: {
    departmentCheck(dept) {
      const departments = this.departments
      for (let item in departments) {
        if (dept == departments[item].key) {
          return departments[item].name
        }
      }
    },

    deleteDoctor(id) {
      Inertia.visit("doctors/destroy", {
        method: "delete",
        data: { id: id }
      })
    }
  }
}
</script>
