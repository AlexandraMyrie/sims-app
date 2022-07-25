<template>
  <layout type="Doctor" title="Ticket" :user="user_type">
    <notification color="info" :icon="mdiMonitorCellphone">
      <b>Responsive table.</b> Collapses on mobile
    </notification>

    <card-component :icon="mdiTicket" title="Tickets" has-table>
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
          <tr v-for="ticket in tickets" :key="ticket">
            <td>{{ ticket.ticket_number }}</td>
            <td>{{ ticket.first_name }}</td>
            <td>{{ ticket.last_name }}</td>
            <td>{{ departmentCheck(ticket.department) }}</td>
            <td>{{ ticket.reason }}</td>
            <td>{{ statusCheck(ticket.status) }}</td>
            <td>
              <div class="flex justify-end mr-1">
                <Link :href="route('tickets.edit', [ticket.key, ticket])">
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
                  @click="deleteTicket(ticket)"
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
    Link
  },
  props: {
    tickets: Object,
    departments: Array,
    user_type: String
  },
  methods: {
    deleteTicket(id) {
      Inertia.visit("tickets/destroy", {
        method: "delete",
        data: { id: id }
      })
    },

    departmentCheck(dept) {
      const departments = this.departments
      for (let item in departments) {
        if (dept == departments[item].key) {
          return departments[item].name
        }
      }
    },
    statusCheck(status) {
      if (status) {
        return "Session Complete"
      }
      return "Waiting"
    }
  }
}
</script>
