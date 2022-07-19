<template>
  <section
    :class="lightBorderStyle"
    class="bg-white border-t border-b p-6 dark:bg-gray-900/70 dark:border-gray-900 dark:text-white"
  >
    <level>
      <h1 class="text-3xl font-semibold leading-tight">
        <slot />
      </h1>
      <jb-button
        v-if="button == 'add'"
        :icon="icon"
        :outline="darkMode"
        small
        color="info"
        :label="label"
        @click="redirect(url)"
      />
    </level>
  </section>
</template>
<script>
import { mdiThemeLightDark } from "@mdi/js"

import { computed } from "vue"
import Level from "@/components/Level.vue"
import JbButton from "@/components/JbButton.vue"
import { Inertia } from "@inertiajs/inertia"

const lightBorderStyle = computed(() => mainStore.lightBorderStyle)

const darkMode = computed(() => mainStore.darkMode)

export default {
  components: {
    JbButton,
    Level
  },
  props: {
    button: {
      type: String,
      default: null
    },
    url: {
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
    }
  },

  methods: {
    redirect(url) {
      Inertia.visit(url, { method: "get" })
    }
  }
}
</script>
