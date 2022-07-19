<script setup>
import { mdiCog } from "@mdi/js"
import { computed } from "vue"
import { useMainStore } from "@/stores/main"
import Icon from "@/components/Icon.vue"
import JbButton from "@/components/JbButton.vue"

defineProps({
  button: {
    type: String,
    default: null
  },

  label: {
    type: String,
    default: null
  },
  labelIcon: {
    type: String,
    default: null
  },
  icon: {
    type: String,
    default: null
  },
  title: {
    type: String,
    required: true
  }
})

const mainStore = useMainStore()

const darkMode = computed(() => mainStore.darkMode)
</script>

<template>
  <section class="px-6 sm:px-0 mb-6 flex items-center justify-between">
    <div class="flex items-center justify-start">
      <icon v-if="labelIcon" :path="icon" class="mr-3" />
      <h1 class="text-2xl">
        {{ title }}
      </h1>
    </div>

    <jb-button
      v-if="button == 'add'"
      :icon="icon"
      :outline="darkMode"
      small
      color="info"
      :label="label"
    />

    <jb-button
      v-if="button == 'settings'"
      :icon="mdiCog"
      :outline="darkMode"
      small
      color="white"
    />
  </section>
</template>
