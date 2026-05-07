<script setup>
import { computed } from 'vue';

const props = defineProps({
    variant: {
        type: String,
        default: 'neutral',
    },
});

const variants = {
    neutral: 'bg-neutral-100 text-neutral-700 ring-neutral-200 dark:bg-neutral-800/70 dark:text-neutral-200 dark:ring-neutral-700/70',
    primary: 'bg-primary-50 text-primary-700 ring-primary-200 dark:bg-primary-500/15 dark:text-primary-200 dark:ring-primary-400/20',
    secondary: 'bg-secondary-50 text-secondary-700 ring-secondary-200 dark:bg-secondary-500/15 dark:text-secondary-200 dark:ring-secondary-400/20',
    accent: 'bg-accent-50 text-accent-700 ring-accent-200 dark:bg-accent-500/15 dark:text-accent-200 dark:ring-accent-400/20',
    success: 'bg-success-50 text-success-700 ring-success-200 dark:bg-success-500/15 dark:text-success-200 dark:ring-success-400/20',
    warning: 'bg-warning-50 text-warning-700 ring-warning-200 dark:bg-warning-500/15 dark:text-warning-200 dark:ring-warning-400/20',
    danger: 'bg-danger-50 text-danger-700 ring-danger-200 dark:bg-danger-500/15 dark:text-danger-200 dark:ring-danger-400/20',
};

const classes = computed(() => [
    'inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium ring-1 ring-inset',
    variants[props.variant] ?? variants.neutral,
]);
</script>

<template>
    <span :class="classes">
        <slot />
    </span>
</template>
