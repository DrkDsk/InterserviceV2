<script setup>
import {computed} from 'vue';
import AppLayout from '../Layouts/AppLayout.vue';
import AppBadge from '../Components/ui/AppBadge.vue';
import AppButton from '../Components/ui/AppButton.vue';
import AppCard from '../Components/ui/AppCard.vue';
import AppIcon from '../Components/AppIcon.vue';
import ChartPanel from '../Components/charts/ChartPanel.vue';
import {useTheme} from '../composables/useTheme';

const {isDark} = useTheme();

const breadcrumbs = [
  {label: 'Home', href: '/dashboard'},
  {label: 'Dashboard'},
];

const kpis = [
  {label: 'Revenue', value: '$128.4k', change: '+12.4%', tone: 'success'},
  {label: 'Active users', value: '18,204', change: '+8.1%', tone: 'primary'},
  {label: 'Conversion rate', value: '4.82%', change: '+1.3%', tone: 'secondary'},
  {label: 'Support tickets', value: '12 open', change: '-24%', tone: 'accent'},
];

const timeline = [
  {
    title: 'Design review approved',
    detail: 'Product team finalized the new onboarding flow.',
    time: '2 min ago',
    type: 'success'
  },
  {
    title: 'Billing sync completed',
    detail: 'Stripe metrics were updated successfully.',
    time: '18 min ago',
    type: 'primary'
  },
  {
    title: 'A/B experiment live',
    detail: 'New CTA treatment is now active on 12% of sessions.',
    time: '1 hour ago',
    type: 'secondary'
  },
  {
    title: 'API latency alert cleared',
    detail: 'Edge latency returned to normal after mitigation.',
    time: '3 hours ago',
    type: 'accent'
  },
];

const activityTable = [
  {name: 'Acme Corp', plan: 'Enterprise', status: 'Active', revenue: '$9,420', owner: 'M. Alvarez'},
  {name: 'Northstar', plan: 'Growth', status: 'Trial', revenue: '$2,130', owner: 'L. Gomez'},
  {name: 'Bluepeak', plan: 'Starter', status: 'Active', revenue: '$740', owner: 'S. Romero'},
  {name: 'Vertex Labs', plan: 'Scale', status: 'Paused', revenue: '$4,910', owner: 'A. Torres'},
];

const chartLabelColor = computed(() => (isDark.value ? '#cbd5e1' : '#475569'));
const chartGridColor = computed(() => (isDark.value ? 'rgba(148,163,184,0.14)' : 'rgba(148,163,184,0.18)'));

const revenueData = computed(() => ({
  labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
  datasets: [
    {
      label: 'Revenue',
      data: [18000, 24000, 21600, 27800, 31200, 33500, 40200],
      borderColor: '#479cf8',
      backgroundColor: 'rgba(71, 156, 248, 0.12)',
      fill: true,
      tension: 0.35,
      pointRadius: 2,
    },
    {
      label: 'Expenses',
      data: [9000, 11000, 9800, 12400, 14000, 13500, 16000],
      borderColor: '#3cb74b',
      backgroundColor: 'rgba(60, 183, 75, 0.1)',
      fill: true,
      tension: 0.35,
      pointRadius: 2,
    },
  ],
}));

const revenueOptions = computed(() => ({
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      labels: {
        color: chartLabelColor.value,
        usePointStyle: true,
        boxWidth: 8,
      },
    },
    tooltip: {
      backgroundColor: isDark.value ? '#020617' : '#ffffff',
      titleColor: isDark.value ? '#f8fafc' : '#0f172a',
      bodyColor: isDark.value ? '#cbd5e1' : '#334155',
      borderColor: isDark.value ? 'rgba(148,163,184,0.2)' : 'rgba(148,163,184,0.2)',
      borderWidth: 1,
    },
  },
  scales: {
    x: {
      ticks: {color: chartLabelColor.value},
      grid: {color: chartGridColor.value},
    },
    y: {
      ticks: {color: chartLabelColor.value},
      grid: {color: chartGridColor.value},
    },
  },
}));

const ordersData = computed(() => ({
  labels: ['Onboarding', 'Retention', 'Expansion', 'Support', 'Billing'],
  datasets: [
    {
      label: 'Requests',
      data: [42, 58, 36, 29, 19],
      backgroundColor: ['#479cf8', '#3cb74b', '#80bfff', '#6fd279', '#1f5290'],
      borderRadius: 4,
    },
  ],
}));

const ordersOptions = computed(() => ({
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {display: false},
  },
  scales: {
    x: {
      ticks: {color: chartLabelColor.value},
      grid: {color: chartGridColor.value},
    },
    y: {
      ticks: {color: chartLabelColor.value},
      grid: {color: chartGridColor.value},
    },
  },
}));

const shareData = computed(() => ({
  labels: ['Product', 'Ops', 'Growth', 'Support'],
  datasets: [
    {
      data: [41, 23, 21, 15],
      backgroundColor: ['#479cf8', '#3cb74b', '#86b8ff', '#9ee3a7'],
      borderWidth: 0,
    },
  ],
}));

const shareOptions = computed(() => ({
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
    title="Dashboard"
    description="A modern command center for product, revenue, and operations."
    :breadcrumbs="breadcrumbs"
  >
    <section class="grid gap-4 lg:grid-cols-[1.6fr_0.9fr]">
      <AppCard>
        <div class="flex h-full flex-col justify-between gap-6 p-6">
          <div class="space-y-4">
            <AppBadge variant="primary" class="uppercase tracking-[0.18em]">
              Live overview
            </AppBadge>
            <div class="space-y-3">
              <h2
                class="max-w-2xl text-3xl font-semibold tracking-tight text-slate-900 dark:text-slate-100 sm:text-4xl">
                A minimal control center with clear signals and calm surfaces.
              </h2>
              <p class="max-w-2xl text-sm leading-6 text-slate-500 dark:text-slate-400 sm:text-base">
                Designed for teams that value fast decisions, sharp visual hierarchy, and a refined interface that stays
                out of the way.
              </p>
            </div>
          </div>

          <div class="flex flex-wrap gap-3">
            <AppButton>View reports</AppButton>
            <AppButton variant="outline">Export data</AppButton>
            <AppButton variant="ghost">Share dashboard</AppButton>
          </div>
        </div>
      </AppCard>

      <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-1">
        <AppCard v-for="stat in kpis.slice(0, 2)" :key="stat.label">
          <div class="p-5">
            <p class="text-sm text-slate-500 dark:text-slate-400">{{ stat.label }}</p>
            <div class="mt-3 flex items-end justify-between gap-4">
              <p class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">
                {{ stat.value }}
              </p>
              <AppBadge :variant="stat.tone">{{ stat.change }}</AppBadge>
            </div>
          </div>
        </AppCard>
      </div>
    </section>

    <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
      <AppCard v-for="stat in kpis" :key="stat.label">
        <div class="flex items-center gap-4 p-5">
          <div
            class="flex h-11 w-11 items-center justify-center rounded-sm bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-300">
            <AppIcon name="fa-gauge-high" class="h-5 w-5"/>
          </div>
          <div class="min-w-0 flex-1">
            <p class="text-sm text-slate-500 dark:text-slate-400">{{ stat.label }}</p>
            <div class="mt-2 flex items-center justify-between gap-3">
              <p class="text-xl font-semibold text-slate-900 dark:text-slate-100">{{ stat.value }}</p>
              <AppBadge :variant="stat.tone">{{ stat.change }}</AppBadge>
            </div>
          </div>
        </div>
      </AppCard>
    </section>

    <section class="grid gap-4 xl:grid-cols-[1.6fr_0.9fr]">
      <ChartPanel
        type="line"
        title="Revenue trend"
        description="Weekly revenue versus expenses with soft contrast."
        :data="revenueData"
        :options="revenueOptions"
        height="280px"
      />

      <AppCard>
        <div class="border-b border-slate-200 px-5 py-4 dark:border-slate-800">
          <h3 class="text-sm font-semibold text-slate-900 dark:text-slate-100">Operations timeline</h3>
          <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Recent events and system movement.</p>
        </div>
        <div class="space-y-4 p-5">
          <article
            v-for="item in timeline"
            :key="item.title"
            class="flex gap-3 rounded-sm border border-slate-200 p-4 dark:border-slate-800"
          >
            <div class="mt-0.5 h-2.5 w-2.5 rounded-full bg-primary-500"/>
            <div class="min-w-0 flex-1">
              <div class="flex items-center justify-between gap-3">
                <h4 class="text-sm font-medium text-slate-900 dark:text-slate-100">{{ item.title }}</h4>
                <span class="text-xs text-slate-400">{{ item.time }}</span>
              </div>
              <p class="mt-1 text-sm leading-6 text-slate-500 dark:text-slate-400">
                {{ item.detail }}
              </p>
            </div>
          </article>
        </div>
      </AppCard>
    </section>

    <section class="grid gap-4 xl:grid-cols-[1.2fr_1fr_0.9fr]">
      <ChartPanel
        type="bar"
        title="Request distribution"
        description="Where teams spend time this week."
        :data="ordersData"
        :options="ordersOptions"
        height="260px"
      />

      <ChartPanel
        type="pie"
        title="Team capacity"
        description="Balance across product and support."
        :data="shareData"
        :options="shareOptions"
        height="260px"
      />

      <AppCard>
        <div class="border-b border-slate-200 px-5 py-4 dark:border-slate-800">
          <h3 class="text-sm font-semibold text-slate-900 dark:text-slate-100">System health</h3>
          <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Everything looks calm and green.</p>
        </div>
        <div class="space-y-4 p-5">
          <div class="flex items-center justify-between">
            <span class="text-sm text-slate-500 dark:text-slate-400">API</span>
            <AppBadge variant="success">Healthy</AppBadge>
          </div>
          <div class="flex items-center justify-between">
            <span class="text-sm text-slate-500 dark:text-slate-400">Database</span>
            <AppBadge variant="primary">Stable</AppBadge>
          </div>
          <div class="flex items-center justify-between">
            <span class="text-sm text-slate-500 dark:text-slate-400">Queue</span>
            <AppBadge variant="secondary">Idle</AppBadge>
          </div>
          <div class="rounded-sm border border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-900">
            <p class="text-xs uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">
              Next action
            </p>
            <p class="mt-2 text-sm text-slate-900 dark:text-slate-100">
              Review onboarding funnel and publish the next release note.
            </p>
          </div>
        </div>
      </AppCard>
    </section>

    <AppCard>
      <div class="border-b border-slate-200 px-5 py-4 dark:border-slate-800">
        <h3 class="text-sm font-semibold text-slate-900 dark:text-slate-100">Recent accounts</h3>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">A compact snapshot of top customers and status.</p>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800">
          <thead class="bg-slate-50/70 dark:bg-slate-950/70">
          <tr>
            <th
              class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
              Account
            </th>
            <th
              class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
              Plan
            </th>
            <th
              class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
              Status
            </th>
            <th
              class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
              Revenue
            </th>
            <th
              class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
              Owner
            </th>
          </tr>
          </thead>
          <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
          <tr v-for="row in activityTable" :key="row.name"
              class="transition hover:bg-slate-50/70 dark:hover:bg-slate-900/80">
            <td class="px-5 py-4 text-sm font-medium text-slate-900 dark:text-slate-100">{{ row.name }}</td>
            <td class="px-5 py-4 text-sm text-slate-600 dark:text-slate-300">{{ row.plan }}</td>
            <td class="px-5 py-4">
              <AppBadge :variant="row.status === 'Active' ? 'success' : row.status === 'Trial' ? 'primary' : 'warning'">
                {{ row.status }}
              </AppBadge>
            </td>
            <td class="px-5 py-4 text-sm text-slate-600 dark:text-slate-300">{{ row.revenue }}</td>
            <td class="px-5 py-4 text-sm text-slate-600 dark:text-slate-300">{{ row.owner }}</td>
          </tr>
          </tbody>
        </table>
      </div>
    </AppCard>
  </AppLayout>
</template>
