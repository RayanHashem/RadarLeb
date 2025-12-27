<script setup lang="ts">
const props = withDefaults(defineProps<{
  message?: string | string[] | null
  variant?: 'default' | 'material'
}>(), {
  variant: 'default'
})

function text(msg?: string | string[] | null) {
  if (!msg) return ""
  return Array.isArray(msg) ? msg.filter(Boolean).join("\n") : msg
}
</script>

<template>
  <div v-if="text(message)" :class="['error-message', props.variant === 'material' ? 'error-message-material' : '']">
    <span v-if="props.variant !== 'material'" class="warning-emoji">⚠️</span>
    <svg v-if="props.variant === 'material'" class="error-icon-material" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M12 8V12M12 16H12.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5"/>
    </svg>
    <p :class="['error-text', props.variant === 'material' ? 'error-text-material' : '']">
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

.warning-emoji {
  font-size: 16px;
  flex-shrink: 0;
  margin-top: 2px;
  line-height: 1;
}

.error-text {
  font-size: 0.875rem;
  color: #ef4444;
  margin: 0;
  line-height: 1.5;
  white-space: pre-line;
}

/* Material Design variant - Pill container for better readability */
.error-message-material {
  display: flex;
  align-items: flex-start;
  gap: 8px;
  margin-top: 6px;
  margin-bottom: 8px;
  background: rgba(0, 0, 0, 0.55);
  border: 1px solid rgba(255, 255, 255, 0.08);
  border-left: 3px solid #FB7185;
  padding: 6px 10px;
  border-radius: 10px;
}

.error-icon-material {
  width: 14px;
  height: 14px;
  flex-shrink: 0;
  color: #FB7185;
  margin-top: 2px;
}

.error-text-material {
  font-size: 12px;
  font-weight: 500;
  line-height: 1.3;
  color: rgba(255, 255, 255, 0.92);
  margin: 0;
  text-align: left;
  white-space: normal;
}
</style>
