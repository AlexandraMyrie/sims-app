<template>
  <div
    :class="{ 'bg-opacity-0': transparent, 'bg-opacity-80': !transparent }"
    class="bg-white fixed z-30 inset-0"
  >
    <slot />
  </div>
</template>

<script>
export default {
  props: {
    transparent: Boolean
  }
}
</script>
