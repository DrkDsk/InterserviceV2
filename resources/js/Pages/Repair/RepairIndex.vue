<script setup>

import AppLayout from "../../Layouts/AppLayout.vue";
import AppCard from "../../Components/ui/AppCard.vue";
import AppBadge from "../../Components/ui/AppBadge.vue";
import AppButton from "../../Components/ui/AppButton.vue";
import {router} from '@inertiajs/vue3'

const breadcrumbs = [
  {label: 'Home', href: '/dashboard'},
  {label: 'Reparaciones'},
];

const onCreateRepecetion = () => {
  router.get('/repair/create');
}

</script>

<template>
  <AppLayout
    title="Reparaciones"
    description="Gestionar reparaciones"
    :breadcrumbs="breadcrumbs"
  >
    <div class="flex flex-col gap-4">
      <AppButton @click="onCreateRepecetion" variant="primary" key="registrar-recepcion" class="py-12 w-full">
        <span class="text-2xl font-semibold">Registrar Recepcion</span>
      </AppButton>
    </div>

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
    </section>
  </AppLayout>
</template>

<style scoped>

</style>
