<script setup>
import { Link } from '@inertiajs/vue3';
import AppIcon from '../AppIcon.vue';

defineProps({
    href: {
        type: String,
        required: true,
    },
    icon: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
        default: false,
    },
    collapsed: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <Link
        :href="href"
        :title="collapsed ? label : undefined"
        class="group relative flex items-center gap-3 rounded-sm px-3 py-2 text-sm transition-all duration-200 ease-in-out"
        :class="active
            ? 'bg-slate-900/5 text-slate-900 dark:bg-white/5 dark:text-white'
            : 'text-slate-600 hover:bg-slate-900/[0.03] hover:text-slate-900 dark:text-slate-400 dark:hover:bg-white/[0.03] dark:hover:text-slate-100'"
    >
        <span
            v-if="active"
            class="absolute inset-y-2 left-0 w-0.5 rounded-full bg-primary-500"
        />

        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-sm border border-slate-200 bg-white/70 text-slate-500 transition group-hover:border-slate-300 group-hover:text-slate-700 dark:border-slate-800 dark:bg-slate-950/70 dark:text-slate-400 dark:group-hover:border-slate-700 dark:group-hover:text-slate-200">
            <AppIcon :name="icon" class="h-4 w-4" />
        </span>

        <span class="truncate transition-all duration-200 ease-in-out" :class="collapsed ? 'max-w-0 opacity-0' : 'max-w-[180px] opacity-100'">
            {{ label }}
        </span>
    </Link>
</template>
