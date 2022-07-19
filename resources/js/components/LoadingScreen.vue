<template>
  <base-backdrop
    class="transform left-1/2 bottom-0 -translate-x-1/2 md:top-1/2 md:-translate-y-1/2 h-screen w-screen overflow-y-auto"
  >
    <div class="grid place-items-center h-screen">
      <div>
        <rise-loader
          :loading="loading"
          color="purple"
          :size="size"
        ></rise-loader>
        <rise-loader
          :loading="loading"
          color="darkblue"
          :size="size"
        ></rise-loader>
      </div>
    </div>
  </base-backdrop>
</template>

<script>
import BaseBackdrop from "@/Components/BaseBackdrop"
import RiseLoader from "vue-spinner/src/RiseLoader.vue"

export default {
  components: { BaseBackdrop, RiseLoader }
}
</script>
