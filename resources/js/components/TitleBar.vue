<script setup>
import { mdiGithub } from "@mdi/js"
import Level from "@/components/Level.vue"
import JbButton from "@/components/JbButton.vue"

defineProps({
  type: {
    type: String,
    default: null
  },
  page: {
    type: String,
    default: null
  }
})
</script>

<template>
  <section class="p-6">
    <level>
      <ul>
        <li>
          <span
            class="inline-block pr-3 text-2xl text-gray-500 dark:text-gray-400"
            >{{ type }}/</span
          ><span
            class="text-2xl last:font-black last:text-black dark:text-gray-100"
            >{{ page }}</span
          >
        </li>
      </ul>
      <!-- <jb-button
        href="https://github.com/justboil/admin-one-vue-tailwind"
        color="info"
        label="Star on GitHub"
        target="_blank"
        :icon="mdiGithub"
      /> -->
    </level>
  </section>
</template>

<style scoped>
li.title-stack-item:not(:last-child):after {
  content: "/";
  @apply inline-block pl-3;
}
</style>
