<script setup>
import { computed } from 'vue';

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
    primary: 'bg-primary-500 text-white hover:bg-primary-600 border border-primary-500',
    secondary: 'bg-secondary-500 text-white hover:bg-secondary-600 border border-secondary-500',
    ghost: 'bg-transparent text-slate-700 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800 border border-transparent',
    outline: 'bg-transparent text-slate-700 hover:bg-slate-50 dark:text-slate-200 dark:hover:bg-slate-900 border border-slate-200 dark:border-slate-800',
};

const sizes = {
    sm: 'h-9 px-3 text-sm',
    md: 'h-10 px-4 text-sm',
    lg: 'h-11 px-5 text-sm',
};

const classes = computed(() => [
    'inline-flex items-center justify-center gap-2 rounded-sm font-medium transition-all duration-200 ease-in-out hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-primary-500/20 disabled:pointer-events-none disabled:opacity-50',
    variants[props.variant] ?? variants.primary,
    sizes[props.size] ?? sizes.md,
    props.fullWidth ? 'w-full' : '',
]);
</script>

<template>
    <button :type="type" :disabled="disabled" :class="classes">
        <slot />
    </button>
</template>
