<!-- class="px-2 py-2 h-12 leading-normal block w-full text-gray-800 bg-white font-sans rounded-lg text-left appearance-none outline-none" -->
<template>
  <div
    :class="{
      'mb-5': label
    }"
  >
    <label v-if="label" :for="id" class="input-label" v-text="label"></label>
    <select
      v-if="type === 'select'"
      :id="id"
      :class="{ 'input-invalid': error }"
      :value="modelValue"
      class="px-2 py-2 h-12 leading-normal block w-full text-gray-800 bg-white font-sans rounded-lg text-left appearance-none outline-none"
      v-bind="$attrs"
      @change="$emit('update:modelValue', $event.target.value)"
    >
      <slot />
    </select>

    <div
      v-else
      :class="{ 'input-invalid': error, [containerClass]: true }"
      class="input-container"
    >
      <i v-if="trailing" :class="trailing" class="trailing" />
      <input
        class="mt-3 px-2 py-2 h-12 leading-normal block w-full text-gray-800 bg-white font-sans rounded-lg text-left appearance-none outline-none"
        :id="id"
        ref="input"
        :type="type"
        :value="modelValue"
        v-bind="containedInputAttributes.attrs"
        @input="$emit('update:modelValue', $event.target.value)"
      />
      <i
        v-if="leading && type !== 'password'"
        :class="leading"
        class="leading"
      />
      <button tabindex="-1" type="button" @click="toggleVisibility">
        <i
          v-if="type === 'password'"
          ref="inputIcon"
          class="fas fa-eye cursor-pointer"
        ></i>
      </button>
    </div>

    <input-error v-if="error" :message="error" />

    <p
      v-if="formattingHelper"
      class="text-gray text-sm mt-2"
      v-text="formattingHelper"
    />
  </div>
</template>

<script>
import InputError from "@/Components/InputError"
import Editor from "@tinymce/tinymce-vue"

export default {
  props: {
    leading: String,
    trailing: String,
    modelValue: [String, Number],
    label: String,
    id: String,
    error: String,
    formattingHelper: String,
    containerClass: String,
    type: {
      type: String,
      default: "text"
    }
  },
  components: {
    Editor,
    InputError
  },
  computed: {
    containedInputAttributes() {
      const { class: className, ...attrs } = this.$attrs
      return { attrs, className }
    }
  },
  methods: {
    toggleVisibility() {
      const passwordInputIsVisible =
        this.$refs.inputIcon.classList.contains("fa-eye")
      if (passwordInputIsVisible) {
        this.$refs.inputIcon.classList.remove("fa-eye")
        this.$refs.inputIcon.classList.add("fa-eye-slash")
        this.$refs.input.type = "text"
      }
      if (!passwordInputIsVisible) {
        this.$refs.inputIcon.classList.remove("fa-eye-slash")
        this.$refs.inputIcon.classList.add("fa-eye")
        this.$refs.input.type = "password"
      }
      this.$refs.input.focus()
    }
  }
}
</script>
