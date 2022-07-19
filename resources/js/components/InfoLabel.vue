<template>
  <div>
    <span class="text-gray-500">{{ title }}:</span> {{ info }}
  </div>
</template>

<script>
export default {
  props: {
    title: String,
    info: String
  }
}
</script>
