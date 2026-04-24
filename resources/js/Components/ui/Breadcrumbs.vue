<script setup>
import AppIcon from '../AppIcon.vue';

defineProps({
    items: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <nav class="flex items-center gap-1 text-xs text-slate-500 dark:text-slate-400" aria-label="Breadcrumb">
        <template v-for="(item, index) in items" :key="`${item.label}-${index}`">
            <component
                :is="item.href ? 'a' : 'span'"
                :href="item.href"
                class="transition hover:text-slate-900 dark:hover:text-slate-100"
                :class="item.href ? 'cursor-pointer' : 'cursor-default text-slate-900 dark:text-slate-100'"
            >
                {{ item.label }}
            </component>
            <AppIcon
                v-if="index < items.length - 1"
                name="chevronRight"
                class="h-3.5 w-3.5 text-slate-300 dark:text-slate-700"
            />
        </template>
    </nav>
</template>
