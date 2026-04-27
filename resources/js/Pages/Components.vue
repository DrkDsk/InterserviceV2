<script setup>
import {ref} from 'vue';
import AppLayout from '../Layouts/AppLayout.vue';
import AppAlert from '../Components/ui/AppAlert.vue';
import AppBadge from '../Components/ui/AppBadge.vue';
import AppButton from '../Components/ui/AppButton.vue';
import AppCard from '../Components/ui/AppCard.vue';
import AppModal from '../Components/ui/AppModal.vue';
import AppIcon from '../Components/AppIcon.vue';

const breadcrumbs = [
  {label: 'Home', href: '/dashboard'},
  {label: 'UI Components'},
];

const showModal = ref(false);

const buttonVariants = [
  {label: 'Primary', variant: 'primary'},
  {label: 'Secondary', variant: 'secondary'},
  {label: 'Ghost', variant: 'ghost'},
  {label: 'Outline', variant: 'outline'},
];


</script>

<template>
  <AppLayout
    title="UI Components"
    description="Reusable building blocks for a clean and scalable dashboard system."
    :breadcrumbs="breadcrumbs"
  >
    <section class="grid gap-4 xl:grid-cols-2">
      
      <AppCard>
        <div class="border-b border-slate-200 px-5 py-4 dark:border-slate-800">
          <h2 class="text-sm font-semibold text-slate-900 dark:text-slate-100">Buttons</h2>
          <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Compact controls with subtle scale on hover.</p>
        </div>
        <div class="flex flex-wrap gap-3 p-5">
          <AppButton v-for="button in buttonVariants" :key="button.label" :variant="button.variant">
            {{ button.label }}
          </AppButton>
        </div>
      </AppCard>

      <AppCard>
        <div class="border-b border-slate-200 px-5 py-4 dark:border-slate-800">
          <h2 class="text-sm font-semibold text-slate-900 dark:text-slate-100">Badges</h2>
          <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Small labels for states, tags, and statuses.</p>
        </div>
        <div class="flex flex-wrap gap-3 p-5">
          <AppBadge variant="neutral">Neutral</AppBadge>
          <AppBadge variant="primary">Primary</AppBadge>
          <AppBadge variant="secondary">Secondary</AppBadge>
          <AppBadge variant="accent">Accent</AppBadge>
          <AppBadge variant="success">Success</AppBadge>
          <AppBadge variant="warning">Warning</AppBadge>
          <AppBadge variant="danger">Danger</AppBadge>
        </div>
      </AppCard>
    </section>

    <section class="grid gap-4 xl:grid-cols-3">
      <AppCard>
        <div class="p-5">
          <p class="text-sm text-slate-500 dark:text-slate-400">Card shell</p>
          <h3 class="mt-2 text-lg font-semibold text-slate-900 dark:text-slate-100">Minimal surface</h3>
          <p class="mt-2 text-sm leading-6 text-slate-500 dark:text-slate-400">
            The card uses rounded-sm, soft borders, and very light shadow depth.
          </p>
        </div>
      </AppCard>
      <AppCard>
        <div class="p-5">
          <p class="text-sm text-slate-500 dark:text-slate-400">Alert shell</p>
          <div class="mt-3">
            <AppAlert variant="info">
              <p class="font-medium">Informational note</p>
              <p class="mt-1 text-sm opacity-90">Used for quiet guidance and system updates.</p>
            </AppAlert>
          </div>
        </div>
      </AppCard>
      <AppCard>
        <div class="p-5">
          <p class="text-sm text-slate-500 dark:text-slate-400">Micro actions</p>
          <div class="mt-3 flex items-center gap-2">
            <button
              class="rounded-sm border border-slate-200 p-2 text-slate-500 transition hover:bg-slate-50 hover:text-slate-900 dark:border-slate-800 dark:hover:bg-slate-900 dark:hover:text-slate-100">
              <AppIcon name="dashboard" class="h-4 w-4"/>
            </button>
            <button
              class="rounded-sm border border-slate-200 p-2 text-slate-500 transition hover:bg-slate-50 hover:text-slate-900 dark:border-slate-800 dark:hover:bg-slate-900 dark:hover:text-slate-100">
              <AppIcon name="search" class="h-4 w-4"/>
            </button>
            <button
              class="rounded-sm border border-slate-200 p-2 text-slate-500 transition hover:bg-slate-50 hover:text-slate-900 dark:border-slate-800 dark:hover:bg-slate-900 dark:hover:text-slate-100">
              <AppIcon name="bell" class="h-4 w-4"/>
            </button>
          </div>
        </div>
      </AppCard>
    </section>

    <AppCard>
      <div class="grid gap-4 p-5 lg:grid-cols-[1fr_auto] lg:items-center">
        <div>
          <p class="text-xs uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Modal demo</p>
          <h3 class="mt-2 text-lg font-semibold text-slate-900 dark:text-slate-100">A refined modal for
            confirmations</h3>
          <p class="mt-2 text-sm leading-6 text-slate-500 dark:text-slate-400">
            Use this pattern for dialogs, quick edits, and focused actions.
          </p>
        </div>
        <div class="flex justify-start lg:justify-end">
          <AppButton @click="showModal = true">Open modal</AppButton>
        </div>
      </div>
    </AppCard>

    <AppModal :show="showModal" title="Create segment" @close="showModal = false">
      <template #subtitle>Choose the audience and confirm the filters.</template>

      <div class="space-y-4 text-sm text-slate-600 dark:text-slate-300">
        <p>
          This modal uses a slightly stronger radius only because dialogs benefit from a more distinct enclosure.
        </p>
        <div class="grid gap-3 sm:grid-cols-2">
          <div class="rounded-sm border border-slate-200 p-4 dark:border-slate-800">
            <p class="text-xs uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Audience</p>
            <p class="mt-2 font-medium text-slate-900 dark:text-slate-100">Active customers</p>
          </div>
          <div class="rounded-sm border border-slate-200 p-4 dark:border-slate-800">
            <p class="text-xs uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Scope</p>
            <p class="mt-2 font-medium text-slate-900 dark:text-slate-100">Last 90 days</p>
          </div>
        </div>
      </div>

      <template #footer>
        <AppButton variant="ghost" @click="showModal = false">Cancel</AppButton>
        <AppButton @click="showModal = false">Save segment</AppButton>
      </template>
    </AppModal>
  </AppLayout>
</template>
