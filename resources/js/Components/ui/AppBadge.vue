<script setup>
import { computed } from 'vue';

const props = defineProps({
    variant: {
        type: String,
        default: 'neutral',
    },
});

const variants = {
    neutral: 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-200',
    primary: 'bg-primary-50 text-primary-700 dark:bg-primary-500/15 dark:text-primary-200',
    secondary: 'bg-secondary-50 text-secondary-700 dark:bg-secondary-500/15 dark:text-secondary-200',
    accent: 'bg-accent-50 text-accent-700 dark:bg-accent-500/15 dark:text-accent-200',
    success: 'bg-brand-50 text-brand-700 dark:bg-brand-500/15 dark:text-brand-200',
    warning: 'bg-amber-50 text-amber-700 dark:bg-amber-500/15 dark:text-amber-200',
    danger: 'bg-rose-50 text-rose-700 dark:bg-rose-500/15 dark:text-rose-200',
};

const classes = computed(() => [
    'inline-flex items-center rounded-sm px-2 py-1 text-xs font-medium ring-1 ring-inset',
    variants[props.variant] ?? variants.neutral,
]);
</script>

<template>
    <span :class="classes">
        <slot />
    </span>
</template>
