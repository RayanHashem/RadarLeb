<script setup lang="ts">
import { AlertCircle } from 'lucide-vue-next';

defineProps<{
  message?: string | string[] | null
}>()

function text(msg?: string | string[] | null) {
  if (!msg) return ""
  return Array.isArray(msg) ? msg.filter(Boolean).join("\n") : msg
}
</script>

<template>
  <div v-if="text(message)" class="error-message">
    <AlertCircle class="error-icon" />
    <p class="error-text">
      {{ text(message) }}
    </p>
  </div>
</template>

<style scoped>
.error-message {
  display: flex;
  align-items: flex-start;
  gap: 8px;
  margin-top: 4px;
  margin-bottom: 8px;
}

.error-icon {
  width: 16px;
  height: 16px;
  color: #ef4444;
  flex-shrink: 0;
  margin-top: 2px;
}

.error-text {
  font-size: 0.875rem;
  color: #ef4444;
  margin: 0;
  line-height: 1.5;
  white-space: pre-line;
}
</style>
