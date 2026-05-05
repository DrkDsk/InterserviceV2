<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import AppCard from "@/Components/ui/AppCard.vue";
import AppSelect from "@/Components/ui/AppSelect.vue";
import AppButton from "@/Components/ui/AppButton.vue";
import AppTextarea from "@/Components/ui/AppTextarea.vue";
import AppInput from "@/Components/ui/AppInput.vue";
import {router, useForm} from "@inertiajs/vue3";
import {route} from "ziggy-js"

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

const form = useForm({
  observations: props.repair.observations,
  solution: props.repair.solution,
  status: props.repair.status,
  notes: props.repair.reception.notes,
  serial_number: props.repair.device.serial_number,
  accessories: props.repair.device.accessories,
  inventory_number: props.repair.device.inventory_number,
  password: props.repair.device.password,
  issue: props.repair.issue,
  brand: props.repair.device.brand,
  model: props.repair.device.model,
})

const goToRepairLogs = () => {
  router.visit(route("repairs.logs", props.repair.id))
}

</script>

<template>
  <AppLayout>
    <div class="mx-auto w-full space-y-4">
      <AppCard class="overflow-hidden">
        <div class="px-6 py-6 sm:px-8">
          <section class="space-y-6">
            <div class="space-y-2">
              <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Recepción</h3>
              <p class="text-sm text-slate-500 dark:text-slate-400">
                Agrega solo las notas necesarias para contextualizar el ingreso.
              </p>
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
                <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Solución</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400">
                  Modifica el estatus y la solución de la reparación
                </p>
              </div>

              <AppSelect
                v-model="form.status"
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
                v-model="form.solution"
                label="Solución"
                :rows="6"
              />

              <a
                @click="goToRepairLogs"
                class=" text-slate-200  hover:text-white/50 cursor-pointer">
                Registrar histórico
              </a>

            </div>

            <div class="justify-end gap-4 flex">
              <AppButton variant="outline">
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
