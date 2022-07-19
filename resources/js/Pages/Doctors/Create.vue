<template>
  <layout
    type="Admin"
    title="Doctors"
    button="add"
    url="doctors/create"
    label="Add Doctor"
    :user="user_type"
  >
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
            v-model="form.password"
            :error="form.errors.password"
            label="Password"
            id="password"
            class="w-full"
          />
        </div>

        <base-input
          v-model="form.department"
          :error="form.errors.department"
          class="w-full"
          label="Department"
          type="select"
        >
          <option disabled hidden selected value="">
            -- Select a Department --
          </option>

          <option
            v-for="department in departments"
            :key="department"
            :value="department.key"
          >
            {{ department.name }}
          </option>
        </base-input>
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
    departments: Object,
    doctor: Object,
    mode: String
  },

  setup(props) {
    const doctor = props.doctor
    const form = useForm({
      first_name: doctor?.first_name,
      last_name: doctor?.last_name,
      middle_initial: doctor?.middle_initial,
      department: doctor?.department,
      email: doctor?.email,
      password: doctor?.password
    })

    function submit() {
      if (props.mode === "Edit") {
        form.put(route("doctors.update", doctor.key))
      } else {
        form.post(route("doctors.store"))
      }
    }

    return { form, submit }
  }
}
</script>
