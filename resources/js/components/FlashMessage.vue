<template>
  <div class="fixed top-14 right-0 m-6">
    <div v-if="show">
      <div
        class="bg-green-200 text-green-900 rounded-lg shadow-md p-6 pr-10"
        style="min-width: 240px"
      >
        <button
          class="opacity-75 cursor-pointer absolute top-0 right-0 py-2 px-3 hover:opacity-100"
        >
          ×
        </button>
        <span class="flex items-center">
          {{ $page.props.flash.success }}
        </span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    this.showFlash()
  },
  data() {
    return {
      show: false
    }
  },
  methods: {
    showFlash() {
      const message = this.$page.props.flash.success

      if (message) {
        this.show = true
        this.message = message

        setTimeout(() => {
          this.show = false
          this.message = null
        }, 5000)
      }
    }
  }
}
</script>
