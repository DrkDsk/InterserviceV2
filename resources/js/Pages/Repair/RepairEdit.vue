<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import AppCard from "@/Components/ui/AppCard.vue";
import AppSelect from "@/Components/ui/AppSelect.vue";
import AppButton from "@/Components/ui/AppButton.vue";
import AppTextarea from "@/Components/ui/AppTextarea.vue";
import AppInput from "@/Components/ui/AppInput.vue";
import {router, useForm} from "@inertiajs/vue3";
import {route} from "ziggy-js"
import {computed} from "vue";
import {useRepairTabs} from "@/composables/useRepairTabs";

const props = defineProps({
  repair: {
    type: Object,
    default: () => {
    },
  },
  statuses: {
    type: Array,
    default: () => []
  }
})

const options = {
  preserveScroll: true,
}

const clientName = computed(() => {
  const name = (props.repair.reception.client?.name ?? props.repair.reception.customer_name).toLowerCase();
  return name
    .split(' ')
    .map(word => word.charAt(0).toUpperCase() + word.slice(1))
    .join(' ');
});

const availableDelivery = computed(() => props.repair.status === "completed")

const technicianName = computed(() => {
  const name = (props.repair.technician.name).toLowerCase();
  return name
    .split(' ')
    .map(word => word.charAt(0).toUpperCase() + word.slice(1))
    .join(' ');
});

const repairTitle = computed(() => `Reparación #${props.repair.id}`);
const repairTabs = useRepairTabs(props.repair.id, {
  logsCount: computed(() => props.repair.logs_count ?? 0),
});

const form = useForm({
  observations: props.repair.observations,
  notes: props.repair.reception.notes,
  serial_number: props.repair.device.serial_number,
  accessories: props.repair.device.accessories,
  inventory_number: props.repair.device.inventory_number,
  password: props.repair.device.password,
  issue: props.repair.issue,
  brand: props.repair.device.brand,
  model: props.repair.device.model,
})

const breadcrumbs = [
  {label: 'Home', href: route('dashboard')},
  {label: 'Reparaciones', href: route('repairs.index')},
  {label: `Reparación #${props.repair.id}`},
];

const solutionForm = useForm({
  status: props.repair.status,
  solution: props.repair.solution,
})

const submitSolution = () => {
  solutionForm.put(route('repairs.update', props.repair.id), options)
}

const openPdf = (type) => {

  const url = route('repairs.pdf.generate', {
    repair: props.repair.id,
    type,
  })

  window.open(url, '_blank', 'noopener,noreferrer');
}

</script>

<template>
  <AppLayout
    :breadcrumbs="breadcrumbs"
    :tabs="repairTabs"
    :title="repairTitle"
    description="Consulta los detalles de recepción, equipo y solución de la reparación."
  >
    <div class="mx-auto w-full space-y-4">
      <AppCard class="overflow-hidden">
        <div class="px-6 py-6 sm:px-8">
          <section class="space-y-6">
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">

              <div class="space-y-2">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Recepción</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400">
                  Agrega solo las notas necesarias para contextualizar el ingreso.
                </p>
              </div>

              <div class="flex-col">
                <p class="text-slate-500 dark:text-slate-400">Cliente:</p>
                <p class="text-5xl text-slate-500 font-semibold">
                  {{ clientName }}
                </p>
              </div>

              <div class="flex-col">
                <p class="text-slate-500 dark:text-slate-400">Técnico:</p>
                <p class="text-5xl text-slate-500 font-semibold">
                  {{ technicianName }}
                </p>
              </div>
            </div>

            <div class="grid gap-4 lg:grid-cols-2">
              <AppTextarea
                v-model="form.notes"
                label="Notas"
                :rows="6"
              />

              <AppTextarea
                v-model="form.issue"
                label="Falla reportada"
                :rows="6"
              />

              <AppTextarea
                v-model="form.observations"
                label="Observaciones"
                :rows="6"
              />

              <AppTextarea
                v-model="form.accessories"
                label="Accesorios"
                :rows="6"
              />
            </div>

            <div class="grid gap-4 lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2">

              <AppInput
                v-model="form.brand"
                label="Marca"
                placeholder="Ej. Apple, Samsung, Lenovo"
              />

              <AppInput
                v-model="form.model"
                label="Modelo"
                placeholder="Ej. iPhone 14, Galaxy A54"
              />

              <AppInput
                v-model="form.serial_number"
                label="Numero de serie"
                placeholder="Serie del equipo"
              />

              <AppInput
                v-model="form.inventory_number"
                label="Numero de inventario"
                placeholder="Folio o referencia interna"
              />

              <AppInput
                v-model="form.password"
                label="Contraseña"
                placeholder="PIN, patron o clave temporal"
              />
            </div>
          </section>
        </div>
      </AppCard>

      <AppCard class="overflow-hidden">
        <div class="px-6 py-6 sm:px-8 h-full">
          <section class="space-y-6 flex flex-col justify-between h-full">
            <div class="space-y-8">

              <div class="space-y-2">
                <div class="flex items-center gap-2 justify-between">
                  <div class="flex flex-col">
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Solución</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                      Modifica el estatus y la solución de la reparación
                    </p>
                  </div>
                </div>
              </div>

              <section class="rounded-[28px] border border-info-200/80 bg-linear-to-br from-info-50 via-white to-white p-5 shadow-[0_18px_45px_rgba(18, 98, 204, 0.11)] dark:border-info-400/15 dark:bg-linear-to-br dark:from-info-500/10 dark:via-[rgba(18,29,51,0.96)] dark:to-[rgba(18,29,51,0.92)]">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                  <div class="space-y-3">
                    <div class="inline-flex items-center gap-2 rounded-full bg-info-100 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.22em] text-info-600 dark:bg-info-500/14 dark:text-info-200">
                      PDF Recepción
                    </div>

                    <div class="space-y-2">
                      <h4 class="text-xl font-semibold tracking-tight text-slate-900 dark:text-slate-50">
                        Visualiza el comprobante de recepción
                      </h4>
                      <p class="max-w-2xl text-sm leading-6 text-slate-600 dark:text-slate-300">
                        Abre una vista PDF lista para revisión, impresión o envío al cliente.
                      </p>
                    </div>
                  </div>

                  <div class="flex flex-col items-stretch gap-3 lg:min-w-65">
                    <AppButton variant="info" size="lg" @click="openPdf('reception')">
                      Ver PDF de recepción
                    </AppButton>
                    <p class="text-center text-xs text-slate-500 dark:text-slate-400">
                      Se abrirá en otra pestaña
                    </p>
                  </div>
                </div>
              </section>

              <section v-if="availableDelivery" class="rounded-[28px] border border-success-200/80 bg-gradient-to-br from-success-50 via-white to-white p-5 shadow-[0_18px_45px_rgba(47,159,115,0.08)] dark:border-success-400/15 dark:bg-gradient-to-br dark:from-success-500/10 dark:via-[rgba(18,29,51,0.96)] dark:to-[rgba(18,29,51,0.92)]">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                  <div class="space-y-3">
                    <div class="inline-flex items-center gap-2 rounded-full bg-success-100 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.22em] text-success-600 dark:bg-success-500/14 dark:text-success-200">
                      PDF Delivery
                    </div>

                    <div class="space-y-2">
                      <h4 class="text-xl font-semibold tracking-tight text-slate-900 dark:text-slate-50">
                        Visualiza el comprobante de entrega
                      </h4>
                      <p class="max-w-2xl text-sm leading-6 text-slate-600 dark:text-slate-300">
                        Abre una vista PDF lista para revisión, impresión o envío al cliente.
                      </p>
                    </div>
                  </div>

                  <div class="flex flex-col items-stretch gap-3 lg:min-w-65">
                    <AppButton variant="success" size="lg" @click="openPdf('delivery')">
                      Ver PDF de entrega
                    </AppButton>
                    <p class="text-center text-xs text-slate-500 dark:text-slate-400">
                      Se abrirá en otra pestaña
                    </p>
                  </div>
                </div>
              </section>

              <div class="grid gap-4 grid-cols-1 lg:grid-cols-2">
                <AppSelect
                  v-model="solutionForm.status"
                  label="Estatus"
                >
                  <option value="" selected disabled>Selecciona un estatus</option>
                  <option
                    v-for="status in statuses"
                    :key="status.value"
                    :value="status.value"
                  >
                    {{ status.label }}
                  </option>
                </AppSelect>

                <AppTextarea
                  v-model="solutionForm.solution"
                  label="Solución"
                  :rows="6"
                />
              </div>
            </div>

            <div class="justify-end gap-4 flex">
              <AppButton variant="outline" @click="submitSolution">
                Actualizar
              </AppButton>
            </div>
          </section>
        </div>
      </AppCard>
    </div>
  </AppLayout>
</template>

<style scoped>

</style>
