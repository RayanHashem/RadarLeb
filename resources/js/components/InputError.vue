<script setup lang="ts">
defineProps<{
  message?: string | string[] | null
}>()

function text(msg?: string | string[] | null) {
  if (!msg) return ""
  return Array.isArray(msg) ? msg.filter(Boolean).join("\n") : msg
}
</script>

<template>
  <p v-if="text(message)" class="text-sm text-red-500 whitespace-pre-line">
    {{ text(message) }}
  </p>
</template>
