<template>
  <layout
    type="Doctor"
    title="Ticket"
    label="Generate Ticket"
    :user="user_type"
  >
    <loading-screen v-if="form.processing" />
    <form @submit.prevent="submit">
      <card-component>
        <div class="grid grid-cols1 gap-4">
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
            <option key="Waiting" :value="false">Waiting</option>
            <option key="In Process" :value="true">Session Complete</option>
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
    ticket: Object,
    user_type: String
  },

  setup(props) {
    const ticket = props.ticket
    const form = useForm({
      key: ticket.key,
      status: ticket?.status
    })

    function submit() {
      form.put(route("tickets.update", [ticket.key, ticket]))
    }

    return { form, submit }
  }
}
</script>
