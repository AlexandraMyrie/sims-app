<template>
  <card-component>
    <level v-if="trendType" class="mb-3" mobile>
      <trend-pill :trend-type="trendType" small />
      <!-- <jb-button
        :icon="mdiTrashCan"
        icon-w="w-4"
        icon-h="h-4"
        color="danger"
        :outline="darkMode"
        small
      /> -->
    </level>
    <level mobile>
      <div>
        <h3 class="text-lg leading-tight text-gray-500 dark:text-gray-400">
          {{ label }}
        </h3>
        <h1 class="text-3xl leading-tight font-semibold">
          <growing-number :value="number" :prefix="prefix" :suffix="suffix" />
        </h1>
      </div>
      <jb-button
        :outline="darkMode"
        small
        color="danger"
        label="Delete"
        @click="deleteDepartment(id)"
      />
    </level>
  </card-component>
</template>
<script>
import { mdiTrashCan } from "@mdi/js"
import { computed } from "vue"

import CardComponent from "@/components/CardComponent.vue"
import GrowingNumber from "@/components/GrowingNumber.vue"
import Icon from "@/components/Icon.vue"
import Level from "@/components/Level.vue"
import TrendPill from "@/components/TrendPill.vue"
import JbButton from "@/components/JbButton.vue"
import { Inertia } from "@inertiajs/inertia"
export default {
  components: {
    JbButton,
    TrendPill,
    Icon,
    Level,
    GrowingNumber,
    CardComponent,
    mdiTrashCan
  },
  props: {
    number: {
      type: Number,
      default: 0
    },
    id: {
      type: String,
      default: null
    },
    icon: {
      type: String,
      default: null
    },
    prefix: {
      type: String,
      default: null
    },
    suffix: {
      type: String,
      default: null
    },
    label: {
      type: String,
      default: null
    },
    color: {
      type: String,
      default: null
    },
    trend: {
      type: String,
      default: null
    },
    trendType: {
      type: Boolean,
      default: null
    }
  },
  methods: {
    deleteDepartment(id) {
      Inertia.visit("departments/destroy", {
        method: "delete",
        data: { id: id }
      })
    }
  }
}

const darkMode = computed(() => mainStore.darkMode)
</script>
