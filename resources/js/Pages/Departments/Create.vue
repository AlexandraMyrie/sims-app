<template>
  <layout
    type="Admin"
    title="Department"
    user="admin"
    :current_user="current_user"
  >
    <loading-screen v-if="form.processing" />

    <form @submit.prevent="submit">
      <card-component>
        <base-input
          v-model="form.name"
          :error="form.errors.name"
          label="Department Name"
          id="name"
          class="w-full"
        />

        <base-input
          v-model="form.status"
          :error="form.errors.status"
          class="w-full"
          label="Status"
          type="select"
        >
          <option disabled hidden selected value="">
            -- Select a Status --
          </option>
          <option key="Active" :value="true">Active</option>
          <option key="Not Active" :value="false">Not Active</option>
        </base-input>
        <div class="flex justify-end">
          <jb-button
            :outline="darkMode"
            small
            color="info"
            label="Add"
            @click="submit()"
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
import { Inertia } from "@inertiajs/inertia"
import { reactive } from "vue"
import { computed } from "vue"
import { useForm } from "@inertiajs/inertia-vue3"
import Loading from "vue-loading-overlay"
import "vue-loading-overlay/dist/vue-loading.css"
import RiseLoader from "vue-spinner/src/RiseLoader.vue"
import LoadingScreen from "@/components/LoadingScreen.vue"

const darkMode = computed(() => mainStore.darkMode)

export default {
  components: {
    Layout,
    BaseInput,
    CardComponent,
    JbButton,
    Loading,

    LoadingScreen
  },
  props: {
    current_user: Object
  },

  setup() {
    const form = useForm({
      name: null,
      department: null,
      status: null
    })

    function submit() {
      form.post(route("departments.store"))
    }

    return { form, submit, isHidden: false }
  }
}
</script>
