<script setup>
import {computed} from 'vue';

const props = defineProps({
  variant: {
    type: String,
    default: 'primary',
  },
  size: {
    type: String,
    default: 'md',
  },
  type: {
    type: String,
    default: 'button',
  },
  disabled: {
    type: Boolean,
    default: false,
  },
  fullWidth: {
    type: Boolean,
    default: false,
  },
});

const variants = {
  primary: 'border border-primary-600/70 bg-primary-500 text-white shadow-[0_12px_28px_rgba(55,116,200,0.22)] hover:-translate-y-0.5 hover:bg-primary-600 dark:border-primary-400/20 dark:bg-primary-500 dark:text-[color:var(--primary-foreground)] dark:shadow-[0_16px_34px_rgba(11,17,27,0.34)] dark:hover:bg-primary-400',
  success: 'border border-success-600/70 bg-success-500 text-white shadow-[0_12px_28px_rgba(47,159,115,0.22)] hover:-translate-y-0.5 hover:bg-success-600 dark:border-success-400/20 dark:bg-success-500 dark:shadow-[0_16px_34px_rgba(11,17,27,0.34)] dark:hover:bg-success-400',
  secondary: 'border border-secondary-200 bg-secondary-50 text-secondary-700 hover:-translate-y-0.5 hover:bg-secondary-100 dark:border-secondary-400/15 dark:bg-secondary-500/12 dark:text-secondary-200 dark:hover:bg-secondary-500/18',
  ghost: 'border border-transparent bg-transparent text-slate-600 hover:bg-white/70 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-white/5 dark:hover:text-white',
  outline: 'border border-[color:var(--border)] bg-[var(--surface)] text-slate-700 hover:border-[color:var(--border-strong)] hover:bg-white/88 hover:text-slate-900 dark:text-slate-200 dark:hover:bg-white/6 dark:hover:text-white',
  danger: 'border border-danger-600/70 bg-danger-500 text-white shadow-[0_12px_28px_rgba(201,61,68,0.18)] hover:-translate-y-0.5 hover:bg-danger-600 dark:border-danger-400/20 dark:bg-danger-500 dark:hover:bg-danger-400',
};

const sizes = {
  sm: 'h-9 px-3 text-sm',
  md: 'h-10 px-4 text-sm',
  lg: 'h-11 px-5 text-sm',
};

const classes = computed(() => [
  'inline-flex items-center justify-center gap-2 rounded-xl font-medium transition-all duration-200 ease-in-out focus:outline-none focus:ring-4 focus:ring-primary-500/15 dark:focus:ring-primary-400/15 disabled:pointer-events-none disabled:opacity-50',
  variants[props.variant] ?? variants.primary,
  sizes[props.size] ?? sizes.md,
  props.fullWidth ? 'w-full' : '',
]);
</script>

<template>
  <button :type="type" :disabled="disabled" :class="classes">
    <slot/>
  </button>
</template>
