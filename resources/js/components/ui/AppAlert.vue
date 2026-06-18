<script setup>
import {computed} from 'vue';
import AppIcon from '../AppIcon.vue';

const props = defineProps({
  variant: {
    type: String,
    default: 'info',
  },
  dismissible: {
    type: Boolean,
    default: false,
  },
});

const emits = defineEmits(['dismiss']);

const variants = {
  info: 'border-primary-200 bg-primary-50/90 text-primary-900 dark:border-primary-400/20 dark:bg-primary-500/12 dark:text-primary-100',
  success: 'border-success-200 bg-success-50/90 text-success-900 dark:border-success-400/20 dark:bg-success-500/12 dark:text-success-100',
  warning: 'border-warning-200 bg-warning-50/95 text-warning-900 dark:border-warning-400/20 dark:bg-warning-500/12 dark:text-warning-100',
  danger: 'border-danger-200 bg-danger-50/95 text-danger-900 dark:border-danger-400/20 dark:bg-danger-500/12 dark:text-danger-100',
};

const classes = computed(() => [
  'rounded-2xl border px-4 py-3 text-sm shadow-soft',
  variants[props.variant] ?? variants.info,
]);
</script>

<template>
  <div :class="classes">
    <div class="flex items-start gap-3">
      <div class="mt-0.5">
        <AppIcon :name="variant === 'success' ? 'fa-gauge-high' : 'fa-bell'" class="h-4 w-4"/>
      </div>
      <div class="min-w-0 flex-1">
        <slot/>
      </div>
      <button
        v-if="dismissible"
        type="button"
        class="rounded-lg p-1 transition hover:bg-black/5 dark:hover:bg-white/5"
        @click="emits('dismiss')"
      >
        <AppIcon name="fa-xmark" class="h-4 w-4"/>
      </button>
    </div>
  </div>
</template>
