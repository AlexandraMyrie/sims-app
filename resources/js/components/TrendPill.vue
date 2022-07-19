<script setup>
import { computed } from "vue"
import { mdiChevronUp, mdiChevronDown, mdiAlertCircleOutline } from "@mdi/js"
import Pill from "@/components/Pill.vue"

const props = defineProps({
  trendType: {
    type: Boolean,
    default: null
  },
  small: Boolean
})

const trendStyle = computed(() => {
  if (props.trendType === "true") {
    return {
      icon: mdiChevronUp,
      style: "success"
    }
  }

  if (props.trendType === "false") {
    return {
      icon: mdiChevronDown,
      style: "danger"
    }
  }

  if (props.trendType === "alert") {
    return {
      icon: mdiAlertCircleOutline,
      style: "warning"
    }
  }

  return {
    style: "info"
  }
})
</script>

<template>
  <div v-if="trendType">
    <pill
      text="Active"
      :type="trendStyle.style"
      :icon="trendStyle.icon"
      :small="small"
    />
  </div>
  <div v-else>
    <pill
      text="Not Active"
      :type="trendStyle.style"
      :icon="trendStyle.icon"
      :small="small"
    />
  </div>
</template>
