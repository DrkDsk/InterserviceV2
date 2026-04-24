<script setup>
import AppIcon from '../AppIcon.vue';

defineProps({
    title: {
        type: String,
        default: 'No data available',
    },
    description: {
        type: String,
        default: '',
    },
    icon: {
        type: String,
        default: 'dashboard',
    },
});
</script>

<template>
    <div class="rounded-sm border border-dashed border-slate-200 bg-white/60 p-8 text-center dark:border-slate-800 dark:bg-slate-900/50">
        <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-sm bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-300">
            <AppIcon :name="icon" class="h-5 w-5" />
        </div>
        <h3 class="text-sm font-semibold text-slate-900 dark:text-slate-100">{{ title }}</h3>
        <p v-if="description" class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ description }}</p>
        <div v-if="$slots.action" class="mt-4">
            <slot name="action" />
        </div>
    </div>
</template>
