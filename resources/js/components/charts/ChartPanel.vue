<script setup>
import { onBeforeUnmount, onMounted, ref, watch } from 'vue';
import Chart from 'chart.js/auto';
import AppCard from '../ui/AppCard.vue';

const props = defineProps({
    type: {
        type: String,
        required: true,
    },
    title: {
        type: String,
        default: '',
    },
    description: {
        type: String,
        default: '',
    },
    data: {
        type: Object,
        required: true,
    },
    options: {
        type: Object,
        default: () => ({}),
    },
    height: {
        type: String,
        default: '260px',
    },
});

const canvas = ref(null);
let chartInstance = null;

const buildChart = () => {
    if (!canvas.value) {
        return;
    }

    if (chartInstance) {
        chartInstance.destroy();
    }

    const data = typeof structuredClone === 'function'
        ? structuredClone(props.data)
        : JSON.parse(JSON.stringify(props.data));

    const options = typeof structuredClone === 'function'
        ? structuredClone(props.options)
        : JSON.parse(JSON.stringify(props.options));

    chartInstance = new Chart(canvas.value, {
        type: props.type,
        data,
        options,
    });
};

onMounted(buildChart);

watch(
    () => [props.type, props.data, props.options],
    () => buildChart(),
    { deep: true },
);

onBeforeUnmount(() => {
    if (chartInstance) {
        chartInstance.destroy();
    }
});
</script>

<template>
    <AppCard>
        <div v-if="title || description" class="border-b border-slate-200 px-5 py-4 dark:border-slate-800">
            <h3 v-if="title" class="text-sm font-semibold text-slate-900 dark:text-slate-100">
                {{ title }}
            </h3>
            <p v-if="description" class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                {{ description }}
            </p>
        </div>
        <div class="px-5 py-5">
            <div :style="{ height }">
                <canvas ref="canvas" />
            </div>
        </div>
    </AppCard>
</template>
