<template>
  <layout
    type="Doctor"
    :mode="mode"
    title="Report"
    user="normal"
    :current_user="current_user"
  >
    <loading-screen v-if="form.processing" />

    <form @submit.prevent="submit">
      <card-component>
        <div class="grid grid-cols1 gap-4">
          <base-input
            v-model="form.ticket"
            :error="form.errors.ticket"
            class="w-full"
            label="Ticket Number"
            type="select"
          >
            <option disabled hidden selected value="">
              -- Select Patients Ticket --
            </option>

            <option v-for="ticket in tickets" :key="ticket" :value="ticket.key">
              {{ ticket.ticket_number }}
            </option>
          </base-input>
        </div>
        <base-input
          v-model="form.diagnosis"
          :error="form.errors.diagnosis"
          label="Comments"
          id="diagnosis"
          class="w-full"
        />

        <div class="flex justify-end">
          <jb-button
            :outline="darkMode"
            small
            color="info"
            label="Submit"
            type="submit"
          />
        </div>
      </card-component>
    </form>
  </layout>
</template>

<script>
import Layout from "@/components/Layout.vue"
import BaseInput from "@/components/BaseInput.vue"
import CardComponent from "@/components/CardComponent.vue"
import JbButton from "@/components/JbButton.vue"
import LoadingScreen from "@/components/LoadingScreen.vue"
import { Inertia } from "@inertiajs/inertia"
import { reactive } from "vue"
import { computed } from "vue"
import { useForm } from "@inertiajs/inertia-vue3"
const darkMode = computed(() => mainStore.darkMode)

export default {
  components: {
    Layout,
    BaseInput,
    CardComponent,
    JbButton,
    LoadingScreen
  },
  props: {
    patient: String,
    report: Object,
    tickets: Object,
    mode: String,
    department: String,
    current_user: Object
  },

  setup(props) {
    const report = props.report
    const patient = props.patient
    const department = props.department
    const form = useForm({
      diagnosis: report?.diagnosis,
      ticket: report?.ticket,
      patient: patient,
      department: department
    })

    function submit() {
      if (props.mode === "Edit") {
        form.put(route("reports.update", patient.key))
      } else {
        form.post(route("reports.store"))
      }
    }

    return { form, submit }
  }
}
</script>
