<script setup>
import { computed } from "vue"
import { useMainStore } from "@/stores/main"
import menu from "@/menu.js"
import NavBar from "@/components/NavBar.vue"
import AsideMenu from "@/components/AsideMenu.vue"
import FooterBar from "@/components/FooterBar.vue"
import Overlay from "@/components/Overlay.vue"
const props = defineProps({
  user: {
    type: String,
    default: null
  },
  current_user: {
    type: Object,
    default: null
  }
})

const mainStore = useMainStore()
const user = props.current_user

mainStore.fullScreenToggle(false)

mainStore.setUser({
  name:
    user["first_name"] +
    " " +
    user["last_name"] +
    " (" +
    checkDepartment(user["department"]) +
    ")",
  email: user["email"],
  avatar:
    "https://avatars.dicebear.com/api/avataaars/example.svg?options[top][]=shortHair&options[accessoriesChance]=93"
})

function checkDepartment(dept) {
  if (dept == "-N5Rmnden9_C_NIxqV1g") {
    return "Imaging Procedures"
  } else if (dept == "-N5S8VlkNi8dupyWiD3g") {
    return "Cardiothoracic Clinic"
  } else if (dept == "-N5S8aBwxeTSxagUDM21") {
    return "Orthopeadic Clinic"
  } else if (dept == "-N5S8hfK5J4ZVdt6CTMM") {
    return "Women's Health Clinic"
  } else if (dept == "-N5S9NiMCWnV4SkAHBwR") {
    return "Blood Bank"
  }
}

const isAsideLgActive = computed(() => mainStore.isAsideLgActive)

const overlayClick = () => {
  mainStore.asideLgToggle(false)
}
</script>

<template>
  <nav-bar />
  <aside-menu :user="props.user" :menu="menu" />
  <slot />

  <overlay
    v-show="isAsideLgActive"
    z-index="z-30"
    @overlay-click="overlayClick"
  />
</template>
