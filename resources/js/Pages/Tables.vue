<script setup>
import AppLayout from '../Layouts/AppLayout.vue';
import AppBadge from '../Components/ui/AppBadge.vue';
import AppButton from '../Components/ui/AppButton.vue';
import AppCard from '../Components/ui/AppCard.vue';
import AppTable from '../Components/ui/AppTable.vue';
import AppIcon from '../Components/AppIcon.vue';
import EmptyState from '../Components/ui/EmptyState.vue';

const breadcrumbs = [
  {label: 'Home', href: 'dashboard'},
  {label: 'Tables'},
];

const columns = [
  {key: 'company', label: 'Company'},
  {key: 'contact', label: 'Contact'},
  {key: 'plan', label: 'Plan'},
  {key: 'status', label: 'Status'},
  {key: 'mrr', label: 'MRR'},
];

const rows = [
  {id: 1, company: 'Acme Corp', contact: 'hola@acme.com', plan: 'Enterprise', status: 'Active', mrr: '$9,400'},
  {id: 2, company: 'Northstar', contact: 'team@northstar.io', plan: 'Growth', status: 'Trial', mrr: '$2,100'},
  {id: 3, company: 'Bluepeak', contact: 'ops@bluepeak.app', plan: 'Starter', status: 'Active', mrr: '$740'},
  {id: 4, company: 'Vertex Labs', contact: 'billing@vertex.dev', plan: 'Scale', status: 'Paused', mrr: '$4,920'},
  {id: 5, company: 'Halo Studio', contact: 'hello@halostudio.co', plan: 'Growth', status: 'Active', mrr: '$3,150'},
  {
    id: 6,
    company: 'Nova Health',
    contact: 'contact@novahealth.ai',
    plan: 'Enterprise',
    status: 'Active',
    mrr: '$11,200'
  },
  {id: 7, company: 'Pinecone', contact: 'support@pinecone.mx', plan: 'Starter', status: 'Trial', mrr: '$560'},
  {id: 8, company: 'Skyline', contact: 'sales@skyline.io', plan: 'Scale', status: 'Active', mrr: '$5,800'},
];

const quickStats = [
  {label: 'Total rows', value: rows.length},
  {label: 'Active', value: rows.filter((row) => row.status === 'Active').length},
  {label: 'Trials', value: rows.filter((row) => row.status === 'Trial').length},
  {label: 'Paused', value: rows.filter((row) => row.status === 'Paused').length},
];
</script>

<template>
  <AppLayout
    title="Tables"
    description="Responsive tables with search, pagination, and subtle SaaS styling."
    :breadcrumbs="breadcrumbs"
  >
    <section class="grid gap-4 md:grid-cols-4">
      <AppCard v-for="stat in quickStats" :key="stat.label">
        <div class="p-5">
          <p class="text-sm text-slate-500 dark:text-slate-400">{{ stat.label }}</p>
          <p class="mt-3 text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">{{ stat.value }}</p>
        </div>
      </AppCard>
    </section>

    <AppTable
      title="Customer directory"
      description="Search the grid and page through the current accounts."
      :columns="columns"
      :rows="rows"
      :searchableKeys="['company', 'contact', 'plan', 'status', 'mrr']"
      searchPlaceholder="Search company, contact, plan..."
      rowKey="id"
    >
      <template #cell-status="{ value }">
        <AppBadge :variant="value === 'Active' ? 'success' : value === 'Trial' ? 'primary' : 'warning'">
          {{ value }}
        </AppBadge>
      </template>
      <template #empty>
        <EmptyState
          title="No matching accounts"
          description="Try a different search term or clear the filter."
          icon="tables"
        />
      </template>
    </AppTable>

    <AppCard>
      <div class="grid gap-4 p-5 lg:grid-cols-[1fr_0.8fr] lg:items-center">
        <div>
          <p class="text-xs uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Table UX</p>
          <h3 class="mt-2 text-lg font-semibold text-slate-900 dark:text-slate-100">Focused on scanning, filtering, and
            actionability.</h3>
          <p class="mt-2 text-sm leading-6 text-slate-500 dark:text-slate-400">
            The table uses thin borders, calm hover states, and compact pagination controls to keep attention on the
            data itself.
          </p>
        </div>
        <div class="flex flex-wrap gap-3 lg:justify-end">
          <AppButton variant="outline">
            <AppIcon name="search" class="h-4 w-4"/>
            Advanced search
          </AppButton>
          <AppButton variant="ghost">
            <AppIcon name="dashboard" class="h-4 w-4"/>
            Create segment
          </AppButton>
        </div>
      </div>
    </AppCard>
  </AppLayout>
</template>
