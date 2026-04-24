<script setup>
import { computed } from 'vue';
import AppLayout from '../Layouts/AppLayout.vue';
import AppCard from '../Components/ui/AppCard.vue';
import ChartPanel from '../Components/charts/ChartPanel.vue';
import AppBadge from '../Components/ui/AppBadge.vue';
import { useTheme } from '../composables/useTheme';

const breadcrumbs = [
    { label: 'Home', href: '/dashboard' },
    { label: 'Charts' },
];

const { isDark } = useTheme();

const chartLabelColor = computed(() => (isDark.value ? '#cbd5e1' : '#475569'));
const chartGridColor = computed(() => (isDark.value ? 'rgba(148,163,184,0.14)' : 'rgba(148,163,184,0.18)'));

const lineData = computed(() => ({
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
    datasets: [
        {
            label: 'Traffic',
            data: [1200, 1800, 1600, 2200, 2500, 2900, 3400],
            borderColor: '#479cf8',
            backgroundColor: 'rgba(71,156,248,0.14)',
            fill: true,
            tension: 0.35,
        },
    ],
}));

const lineOptions = computed(() => ({
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            labels: { color: chartLabelColor.value, usePointStyle: true },
        },
    },
    scales: {
        x: { ticks: { color: chartLabelColor.value }, grid: { color: chartGridColor.value } },
        y: { ticks: { color: chartLabelColor.value }, grid: { color: chartGridColor.value } },
    },
}));

const barData = computed(() => ({
    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
    datasets: [
        {
            label: 'Orders',
            data: [24, 34, 28, 41, 45, 39, 53],
            backgroundColor: ['#479cf8', '#3cb74b', '#479cf8', '#3cb74b', '#479cf8', '#3cb74b', '#479cf8'],
            borderRadius: 4,
        },
    ],
}));

const barOptions = computed(() => ({
    responsive: true,
    maintainAspectRatio: false,
    plugins: { legend: { display: false } },
    scales: {
        x: { ticks: { color: chartLabelColor.value }, grid: { color: chartGridColor.value } },
        y: { ticks: { color: chartLabelColor.value }, grid: { color: chartGridColor.value } },
    },
}));

const pieData = computed(() => ({
    labels: ['Product', 'Growth', 'Support', 'Platform'],
    datasets: [
        {
            data: [36, 24, 18, 22],
            backgroundColor: ['#479cf8', '#3cb74b', '#86b8ff', '#9ee3a7'],
            borderWidth: 0,
        },
    ],
}));

const pieOptions = computed(() => ({
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            position: 'bottom',
            labels: {
                color: chartLabelColor.value,
                usePointStyle: true,
                boxWidth: 8,
            },
        },
    },
}));
</script>

<template>
    <AppLayout
        title="Charts"
        description="Modern chart surfaces with clear data storytelling."
        :breadcrumbs="breadcrumbs"
    >
        <section class="grid gap-4 md:grid-cols-3">
            <AppCard>
                <div class="p-5">
                    <p class="text-sm text-slate-500 dark:text-slate-400">Sessions</p>
                    <div class="mt-3 flex items-end justify-between">
                        <p class="text-2xl font-semibold text-slate-900 dark:text-slate-100">24.8k</p>
                        <AppBadge variant="primary">+18%</AppBadge>
                    </div>
                </div>
            </AppCard>
            <AppCard>
                <div class="p-5">
                    <p class="text-sm text-slate-500 dark:text-slate-400">Bounce rate</p>
                    <div class="mt-3 flex items-end justify-between">
                        <p class="text-2xl font-semibold text-slate-900 dark:text-slate-100">38.2%</p>
                        <AppBadge variant="success">-4%</AppBadge>
                    </div>
                </div>
            </AppCard>
            <AppCard>
                <div class="p-5">
                    <p class="text-sm text-slate-500 dark:text-slate-400">Avg. order value</p>
                    <div class="mt-3 flex items-end justify-between">
                        <p class="text-2xl font-semibold text-slate-900 dark:text-slate-100">$142</p>
                        <AppBadge variant="secondary">+7%</AppBadge>
                    </div>
                </div>
            </AppCard>
        </section>

        <section class="grid gap-4 xl:grid-cols-2">
            <ChartPanel type="line" title="Traffic trend" description="A smooth line chart for weekly audience flow." :data="lineData" :options="lineOptions" />
            <ChartPanel type="bar" title="Order activity" description="Compact bars for a quick operational read." :data="barData" :options="barOptions" />
        </section>

        <section class="grid gap-4 xl:grid-cols-[0.95fr_1.05fr]">
            <ChartPanel type="pie" title="Department allocation" description="A restrained split across the core teams." :data="pieData" :options="pieOptions" />

            <AppCard>
                <div class="border-b border-slate-200 px-5 py-4 dark:border-slate-800">
                    <h3 class="text-sm font-semibold text-slate-900 dark:text-slate-100">Reading the charts</h3>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Short notes to make the dashboard easy to scan.</p>
                </div>
                <div class="space-y-4 p-5 text-sm leading-6 text-slate-600 dark:text-slate-300">
                    <p>
                        The color system stays within the brand palette so the visual language feels cohesive and calm.
                    </p>
                    <p>
                        Spacing is intentionally generous, with thin borders and soft contrasts to keep the presentation minimal.
                    </p>
                    <p>
                        On dark mode, chart labels adapt to maintain contrast without turning the interface overly saturated.
                    </p>
                </div>
            </AppCard>
        </section>
    </AppLayout>
</template>
