<script setup>
import { computed } from 'vue';

const props = defineProps({
    name: {
        type: String,
        required: true,
    },
});

const iconMap = {
    dashboard: {
        viewBox: '0 0 24 24',
        shapes: [
            { type: 'path', d: 'M4 5.75A1.75 1.75 0 0 1 5.75 4h4.5A1.75 1.75 0 0 1 12 5.75v4.5A1.75 1.75 0 0 1 10.25 12h-4.5A1.75 1.75 0 0 1 4 10.25z' },
            { type: 'path', d: 'M12 5.75A1.75 1.75 0 0 1 13.75 4h4.5A1.75 1.75 0 0 1 20 5.75v2.5A1.75 1.75 0 0 1 18.25 10h-4.5A1.75 1.75 0 0 1 12 8.25z' },
            { type: 'path', d: 'M12 13.75A1.75 1.75 0 0 1 13.75 12h4.5A1.75 1.75 0 0 1 20 13.75v4.5A1.75 1.75 0 0 1 18.25 20h-4.5A1.75 1.75 0 0 1 12 18.25z' },
            { type: 'path', d: 'M4 13.75A1.75 1.75 0 0 1 5.75 12h4.5A1.75 1.75 0 0 1 12 13.75v6.5A1.75 1.75 0 0 1 10.25 22h-4.5A1.75 1.75 0 0 1 4 20.25z' },
        ],
    },
    tables: {
        viewBox: '0 0 24 24',
        shapes: [
            { type: 'path', d: 'M5 5.75A1.75 1.75 0 0 1 6.75 4h10.5A1.75 1.75 0 0 1 19 5.75v12.5A1.75 1.75 0 0 1 17.25 20H6.75A1.75 1.75 0 0 1 5 18.25z' },
            { type: 'path', d: 'M5 9h14M5 13h14M9 4v16M15 4v16' },
        ],
    },
    forms: {
        viewBox: '0 0 24 24',
        shapes: [
            { type: 'path', d: 'M5 7.5h14M5 12h10M5 16.5h14' },
            { type: 'path', d: 'M17.5 6.5a1 1 0 1 0 0 2a1 1 0 0 0 0-2M12.5 11a1 1 0 1 0 0 2a1 1 0 0 0 0-2M8.5 15.5a1 1 0 1 0 0 2a1 1 0 0 0 0-2' },
        ],
    },
    charts: {
        viewBox: '0 0 24 24',
        shapes: [
            { type: 'path', d: 'M5 19.25A1.75 1.75 0 0 1 6.75 17.5h10.5A1.75 1.75 0 0 1 19 19.25' },
            { type: 'path', d: 'M7 15.5V11M12 15.5V8M17 15.5V5' },
        ],
    },
    components: {
        viewBox: '0 0 24 24',
        shapes: [
            { type: 'path', d: 'M8 4.75A1.75 1.75 0 0 1 9.75 3h4.5A1.75 1.75 0 0 1 16 4.75v4.5A1.75 1.75 0 0 1 14.25 11h-4.5A1.75 1.75 0 0 1 8 9.25z' },
            { type: 'path', d: 'M4 14.75A1.75 1.75 0 0 1 5.75 13h2.5A1.75 1.75 0 0 1 10 14.75v2.5A1.75 1.75 0 0 1 8.25 19h-2.5A1.75 1.75 0 0 1 4 17.25zM14 14.75A1.75 1.75 0 0 1 15.75 13h4.5A1.75 1.75 0 0 1 22 14.75v2.5A1.75 1.75 0 0 1 20.25 19h-4.5A1.75 1.75 0 0 1 14 17.25z' },
        ],
    },
    settings: {
        viewBox: '0 0 24 24',
        shapes: [
            { type: 'path', d: 'M11.5 3.75a1.5 1.5 0 0 1 1 0l1.03.41a1.5 1.5 0 0 0 1.47-.23l.86-.69a1.5 1.5 0 0 1 1.98.07l.9.9a1.5 1.5 0 0 1 .07 1.98l-.69.86a1.5 1.5 0 0 0-.23 1.47l.41 1.03a1.5 1.5 0 0 1 0 1l-.41 1.03a1.5 1.5 0 0 0 .23 1.47l.69.86a1.5 1.5 0 0 1-.07 1.98l-.9.9a1.5 1.5 0 0 1-1.98.07l-.86-.69a1.5 1.5 0 0 0-1.47-.23l-1.03.41a1.5 1.5 0 0 1-1 0l-1.03-.41a1.5 1.5 0 0 0-1.47.23l-.86.69a1.5 1.5 0 0 1-1.98-.07l-.9-.9a1.5 1.5 0 0 1-.07-1.98l.69-.86a1.5 1.5 0 0 0 .23-1.47l-.41-1.03a1.5 1.5 0 0 1 0-1l.41-1.03a1.5 1.5 0 0 0-.23-1.47l-.69-.86a1.5 1.5 0 0 1 .07-1.98l.9-.9a1.5 1.5 0 0 1 1.98-.07l.86.69a1.5 1.5 0 0 0 1.47.23z' },
            { type: 'path', d: 'M12 15.25a3.25 3.25 0 1 0 0-6.5a3.25 3.25 0 1 0 0 6.5' },
        ],
    },
    sun: {
        viewBox: '0 0 24 24',
        shapes: [
            { type: 'path', d: 'M12 4V2.75M12 21.25V20M4.75 12H3.5M20.5 12h-1.25M6.2 6.2 5.3 5.3M18.7 18.7l-.9-.9M6.2 17.8 5.3 18.7M18.7 5.3l-.9.9' },
            { type: 'path', d: 'M12 7.25a4.75 4.75 0 1 1 0 9.5a4.75 4.75 0 0 1 0-9.5' },
        ],
    },
    moon: {
        viewBox: '0 0 24 24',
        shapes: [
            { type: 'path', d: 'M15.9 3.75a8.5 8.5 0 1 0 4.35 14.85A9.75 9.75 0 1 1 15.9 3.75' },
        ],
    },
    menu: {
        viewBox: '0 0 24 24',
        shapes: [
            { type: 'path', d: 'M4 6h16M4 12h16M4 18h16' },
        ],
    },
    search: {
        viewBox: '0 0 24 24',
        shapes: [
            { type: 'path', d: 'M10.5 18a7.5 7.5 0 1 1 0-15a7.5 7.5 0 0 1 0 15' },
            { type: 'path', d: 'M16.25 16.25 20 20' },
        ],
    },
    bell: {
        viewBox: '0 0 24 24',
        shapes: [
            { type: 'path', d: 'M6.75 9.5a5.25 5.25 0 1 1 10.5 0v2.35c0 .88.27 1.73.77 2.44l1.23 1.74c.44.62.01 1.47-.75 1.47H5.5c-.76 0-1.19-.85-.75-1.47l1.23-1.74c.5-.71.77-1.56.77-2.44z' },
            { type: 'path', d: 'M10 19a2 2 0 0 0 4 0' },
        ],
    },
    user: {
        viewBox: '0 0 24 24',
        shapes: [
            { type: 'path', d: 'M12 12.5a4.5 4.5 0 1 0 0-9a4.5 4.5 0 0 0 0 9' },
            { type: 'path', d: 'M4.75 19.25a7.25 7.25 0 0 1 14.5 0' },
        ],
    },
    chevronLeft: {
        viewBox: '0 0 24 24',
        shapes: [
            { type: 'path', d: 'M14.5 6.75 9.25 12l5.25 5.25' },
        ],
    },
    chevronRight: {
        viewBox: '0 0 24 24',
        shapes: [
            { type: 'path', d: 'M9.5 6.75 14.75 12 9.5 17.25' },
        ],
    },
    chevronDown: {
        viewBox: '0 0 24 24',
        shapes: [
            { type: 'path', d: 'M6.75 9.5 12 14.75 17.25 9.5' },
        ],
    },
    close: {
        viewBox: '0 0 24 24',
        shapes: [
            { type: 'path', d: 'M6.75 6.75 17.25 17.25M17.25 6.75 6.75 17.25' },
        ],
    },
};

const current = computed(() => iconMap[props.name] ?? iconMap.dashboard);
</script>

<template>
    <svg
        :viewBox="current.viewBox"
        fill="none"
        stroke="currentColor"
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="1.75"
        aria-hidden="true"
    >
        <template v-for="(shape, index) in current.shapes" :key="index">
            <path v-if="shape.type === 'path'" :d="shape.d" />
            <circle
                v-else-if="shape.type === 'circle'"
                :cx="shape.cx"
                :cy="shape.cy"
                :r="shape.r"
            />
        </template>
    </svg>
</template>
