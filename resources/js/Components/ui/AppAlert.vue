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
  info: 'border-primary-200 bg-primary-50 text-primary-900 dark:border-primary-500/20 dark:bg-primary-500/10 dark:text-primary-100',
  success: 'border-brand-200 bg-brand-50 text-brand-900 dark:border-brand-500/20 dark:bg-brand-500/10 dark:text-brand-100',
  warning: 'border-amber-200 bg-amber-50 text-amber-900 dark:border-amber-500/20 dark:bg-amber-500/10 dark:text-amber-100',
  danger: 'border-rose-200 bg-rose-50 text-rose-900 dark:border-rose-500/20 dark:bg-rose-500/10 dark:text-rose-100',
};

const classes = computed(() => [
  'rounded-sm border px-4 py-3 text-sm',
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
        class="rounded-sm p-1 transition hover:bg-black/5 dark:hover:bg-white/5"
        @click="emits('dismiss')"
      >
        <AppIcon name="fa-xmark" class="h-4 w-4"/>
      </button>
    </div>
  </div>
</template>
