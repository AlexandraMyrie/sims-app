<script setup>
import AsideMenuItem from "@/components/AsideMenuItem.vue"

defineProps({
  isSubmenuList: {
    type: Boolean,
    default: false
  },
  menu: {
    type: Array,
    default: () => []
  },
  user: {
    type: String,
    default: null
  }
})

const emit = defineEmits(["menu-click"])

const menuClick = (event, item) => {
  emit("menu-click", event, item)
}
</script>

<template>
  <ul>
    <aside-menu-item
      v-for="(item, index) in menu"
      :user="user"
      :key="index"
      :item="item"
      :is-submenu-list="isSubmenuList"
      @menu-click="menuClick"
    />
  </ul>
</template>
