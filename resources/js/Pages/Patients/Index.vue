<template>
  <layout
    type="Doctor"
    title="Patients"
    button="add"
    url="patients/create"
    label="Add Patient"
    :user="user_type"
    :current_user="current_user"
  >
    <!-- <notification
      color="info"
      :icon="mdiGithub"
    >
     SIMS System is currently in development
      <a
        href="https://github.com/justboil/admin-one-vue-tailwind"
        class="underline"
        target="_blank"
      >GitHub</a>
      <template #right>
        <jb-button
          href="https://github.com/justboil/admin-one-vue-tailwind"
          :icon="mdiGithub"
          :outline="darkMode"
          label="GitHub"
          target="_blank"
          small
        />
      </template>
    </notification> -->

    <notification color="info" :icon="mdiMonitorCellphone">
      <b>Responsive table.</b> Collapses on mobile
    </notification>

    <card-component :icon="mdiTicket" title="Patients" has-table>
      <base-table
        ><thead>
          <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Middle Initial</th>
            <th>Email</th>

            <th />
          </tr>
        </thead>
        <tbody>
          <tr v-for="patient in patients" :key="patient">
            <td>{{ patient.first_name }}</td>
            <td>{{ patient.last_name }}</td>
            <td>{{ patient.middle_initial }}</td>
            <td>{{ patient.email }}</td>

            <td>
              <div class="flex justify-end -ml-28 mr-1">
                <Link :href="route('patients.show', patient.key)">
                  <jb-button
                    :outline="darkMode"
                    color="info"
                    label="View"
                    class="mr-4"
                  />
                </Link>

                <Link :href="route('patients.edit', patient.key)">
                  <jb-button
                    v-if="user_type != 'admin'"
                    :outline="darkMode"
                    color="success"
                    label="Edit"
                    class="mr-4"
                  />
                </Link>
                <jb-button
                  v-if="user_type != 'admin'"
                  :outline="darkMode"
                  color="danger"
                  label="Delete"
                  @click="deletePatient(patient.key)"
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
import BaseInput from "@/components/BaseInput.vue"
import TitleSubBar from "@/components/TitleSubBar.vue"
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
    Link
  },
  props: {
    patients: Object,
    user_type: String,
    current_user: Object
  },
  methods: {
    deletePatient(id) {
      Inertia.visit("patients/destroy", {
        method: "delete",
        data: { id: id }
      })
    },

    editPatient(id) {
      Inertia.visit("patients/edit", {
        method: "get",
        data: { id: id }
      })
    }
  }
}
</script>
