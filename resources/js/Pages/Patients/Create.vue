<template>
  <layout type="Doctor" title="Patients" :user="user_type">
    <loading-screen v-if="form.processing" />
    <form @submit.prevent="submit">
      <card-component>
        <div class="grid grid-cols-3 gap-4">
          <base-input
            v-model="form.first_name"
            :error="form.errors.first_name"
            label="First Name"
            id="first_name"
            class="w-full"
          />
          <base-input
            v-model="form.last_name"
            :error="form.errors.last_name"
            label="Last Name"
            id="last_name"
            class="w-full"
          />
          <base-input
            v-model="form.middle_initial"
            :error="form.errors.middle_initial"
            label="Middle Initial"
            id="middle_initial"
            class="w-full"
          />
        </div>

        <div class="grid grid-cols-2 gap-4">
          <base-input
            v-model="form.email"
            :error="form.errors.email"
            label="Email"
            id="email"
            class="w-full"
          />
          <base-input
            v-model="form.contact_number"
            :error="form.errors.contact_number"
            label="Contact Number"
            id="contact_number"
            class="w-full"
          />
        </div>
        <div class="grid grid-cols-2 gap-4">
          <base-input
            v-model="form.emergency_name"
            :error="form.errors.emergency_name"
            label="Emergency Contact Name"
            id="emergency_name"
            class="w-full"
          />
          <base-input
            v-model="form.emergency_contact_number"
            :error="form.errors.emergency_contact_number"
            label="Emergency Contact Number"
            id="emergency_contact_number"
            class="w-full"
          />
        </div>
        <div class="grid grid-cols-2 gap-4">
          <base-input
            v-model="form.national_id"
            :error="form.errors.national_id"
            label="National ID"
            id="national_id"
            class="w-full"
          />
          <base-input
            v-model="form.trn"
            :error="form.errors.trn"
            label="TRN"
            id="trn"
            class="w-full"
          />
        </div>
        <div class="grid grid-cols1 gap-4">
          <base-input
            v-model="form.gender"
            :error="form.errors.gender"
            class="w-full"
            label="Gender"
            type="select"
          >
            <option disabled hidden selected value="">
              -- Select a Status --
            </option>
            <option key="Active" :value="true">Male</option>
            <option key="Not Active" :value="false">Female</option>
          </base-input>
        </div>

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
    patient: Object,
    location: String,
    mode: String,
    user_type: String
  },

  setup(props) {
    const patient = props.patient
    const form = useForm({
      first_name: patient?.first_name,
      last_name: patient?.last_name,
      middle_initial: patient?.middle_initial,
      email: patient?.email,
      contact_number: patient?.contact_number,
      trn: patient?.trn,
      national_id: patient?.national_id,
      emergency_name: patient?.emergency_name,
      emergency_contact_number: patient?.emergency_contact_number,
      gender: patient?.gender
    })

    function submit() {
      if (props.mode === "Edit") {
        form.put(route("patients.update", patient.key))
      } else {
        form.post(route("patients.store"))
      }
    }

    return { form, submit }
  }
}
</script>
