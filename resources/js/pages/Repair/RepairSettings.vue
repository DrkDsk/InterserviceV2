<script setup>
import {computed, ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import {route} from "ziggy-js";

import AppLayout from "@/layouts/AppLayout.vue";
import AppAlert from "@/components/ui/AppAlert.vue";
import AppButton from "@/components/ui/AppButton.vue";
import AppCard from "@/components/ui/AppCard.vue";
import AppIcon from "@/components/AppIcon.vue";
import AppInput from "@/components/ui/AppInput.vue";
import AppModal from "@/components/ui/AppModal.vue";
import {useRepairTabs} from "@/composables/useRepairTabs";

const confirmationWord = 'Eliminar';

const props = defineProps({
  repair: {
    type: Object,
    default: () => ({}),
  },
});

const deleteRepairModalOpen = ref(false);
const deleteLogsModalOpen = ref(false);

const deleteRepairForm = useForm({
  confirmation: '',
});

const deleteLogsForm = useForm({
  confirmation: '',
});

const repairLabel = computed(() => props.repair.reception?.folio ?? `#${props.repair.id}`);
const clientName = computed(() => {
  const client = props.repair.reception?.client;

  if (client?.name) {
    return client.name;
  }

  return props.repair.reception?.customer_name ?? 'Sin cliente asignado';
});

const deleteRepairDisabled = computed(() => {
  return deleteRepairForm.processing || deleteRepairForm.confirmation !== confirmationWord;
});

const deleteLogsDisabled = computed(() => {
  return deleteLogsForm.processing || deleteLogsForm.confirmation !== confirmationWord;
});

const hasLogs = computed(() => (props.repair.logs_count ?? 0) > 0);
const repairTitle = computed(() => `Reparación #${props.repair.id}`);
const repairTabs = useRepairTabs(props.repair.id, {
  logsCount: computed(() => props.repair.logs_count ?? 0),
});

const breadcrumbs = computed(() => ([
  {label: 'Home', href: route('dashboard')},
  {label: 'Reparaciones', href: route('repairs.index')},
  {label: `Reparación #${props.repair.id}`},
]));

const closeDeleteRepairModal = () => {
  deleteRepairModalOpen.value = false;
  deleteRepairForm.reset();
  deleteRepairForm.clearErrors();
};

const closeDeleteLogsModal = () => {
  deleteLogsModalOpen.value = false;
  deleteLogsForm.reset();
  deleteLogsForm.clearErrors();
};

const submitDeleteRepair = () => {
  deleteRepairForm.delete(route('repairs.destroy', props.repair.id), {
    preserveScroll: true,
    onSuccess: () => {
      closeDeleteRepairModal();
    },
  });
};

const submitDeleteLogs = () => {
  deleteLogsForm.delete(route('repairs.logs.clear', props.repair.id), {
    preserveScroll: true,
    onSuccess: () => {
      closeDeleteLogsModal();
    },
  });
};
</script>

<template>
  <AppLayout
    :title="repairTitle"
    description="Administra acciones sensibles y permanentes para esta reparación."
    :breadcrumbs="breadcrumbs"
    :tabs="repairTabs"
  >
    <div class="mx-auto w-full space-y-4">
      <AppCard class="overflow-hidden">
        <div class="px-6 py-6 sm:px-8">
          <section class="space-y-6">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
              <div class="space-y-2">
                <p class="text-xs uppercase tracking-[0.2em] text-rose-500">Danger Zone</p>
                <h2 class="text-xl font-semibold text-slate-900 dark:text-slate-100">
                  Configuración destructiva de la reparación
                </h2>
                <p class="max-w-2xl text-sm leading-6 text-slate-500 dark:text-slate-400">
                  Estas acciones son permanentes y pueden afectar información operativa relacionada con la reparación.
                  Revísalas con cuidado antes de continuar.
                </p>
              </div>

              <div class="rounded-sm border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-900 dark:border-rose-500/20 dark:bg-rose-500/10 dark:text-rose-100">
                <p class="font-medium">{{ repairLabel }}</p>
                <p class="mt-1 text-rose-700 dark:text-rose-200">{{ clientName }}</p>
              </div>
            </div>

            <AppAlert variant="danger">
              <p class="font-medium">Esta acción no se puede deshacer.</p>
              <p class="mt-1 text-sm/6">
                Usa esta sección solo cuando necesites limpiar logs de forma permanente o retirar por completo la
                reparación y sus relaciones asociadas.
              </p>
            </AppAlert>

            <div class="rounded-sm border border-rose-200/80 dark:border-rose-500/20">
              <div class="divide-y divide-rose-200/80 dark:divide-rose-500/20">
                <div class="grid gap-4 px-5 py-5 lg:grid-cols-[1fr_auto] lg:items-center">
                  <div class="space-y-1.5">
                    <div class="flex items-center gap-2 text-slate-900 dark:text-slate-100">
                      <AppIcon name="fa-trash" class="h-4 w-4 text-rose-500"/>
                      <h3 class="text-base font-semibold">Eliminar reparación completa</h3>
                    </div>
                    <p class="text-sm leading-6 text-slate-500 dark:text-slate-400">
                      Elimina la reparación de forma permanente. Si la recepción y el dispositivo no están siendo usados
                      por otra reparación, también se eliminarán para evitar datos huérfanos.
                    </p>
                    <p class="text-sm leading-6 text-slate-500 dark:text-slate-400">
                      Todos los logs asociados serán eliminados permanentemente.
                    </p>
                  </div>

                  <div class="flex justify-start lg:justify-end">
                    <AppButton
                      variant="outline"
                      class="border-rose-200 text-rose-600 hover:border-rose-300 hover:bg-rose-50 hover:text-rose-700 dark:border-rose-500/30 dark:text-rose-300 dark:hover:bg-rose-500/10"
                      @click="deleteRepairModalOpen = true"
                    >
                      Eliminar reparación
                    </AppButton>
                  </div>
                </div>

                <div
                  v-if="hasLogs"
                  class="grid gap-4 px-5 py-5 lg:grid-cols-[1fr_auto] lg:items-center"
                >
                  <div class="space-y-1.5">
                    <div class="flex items-center gap-2 text-slate-900 dark:text-slate-100">
                      <AppIcon name="fa-trash" class="h-4 w-4 text-rose-500"/>
                      <h3 class="text-base font-semibold">Eliminar logs</h3>
                    </div>
                    <p class="text-sm leading-6 text-slate-500 dark:text-slate-400">
                      Borra únicamente el historial de logs asociado a esta reparación.
                    </p>
                    <p class="text-sm leading-6 text-slate-500 dark:text-slate-400">
                      La reparación, el dispositivo y la recepción permanecerán intactos.
                    </p>
                    <p class="text-sm leading-6 text-slate-500 dark:text-slate-400">
                      Logs actuales: {{ repair.logs_count ?? 0 }}
                    </p>
                  </div>

                  <div class="flex justify-start lg:justify-end">
                    <AppButton
                      variant="outline"
                      class="border-rose-200 text-rose-600 hover:border-rose-300 hover:bg-rose-50 hover:text-rose-700 dark:border-rose-500/30 dark:text-rose-300 dark:hover:bg-rose-500/10"
                      @click="deleteLogsModalOpen = true"
                    >
                      Eliminar logs
                    </AppButton>
                  </div>
                </div>

                <div v-else class="px-5 py-5">
                  <AppAlert variant="info">
                    <p class="font-medium">No hay logs para eliminar.</p>
                    <p class="mt-1 text-sm/6">
                      Esta reparación todavía no tiene historial registrado, así que no hay acciones destructivas
                      disponibles para los logs.
                    </p>
                  </AppAlert>
                </div>
              </div>
            </div>
          </section>
        </div>
      </AppCard>
    </div>

    <AppModal
      :show="deleteRepairModalOpen"
      title="Eliminar reparación"
      @close="closeDeleteRepairModal"
    >
      <template #subtitle>
        Confirma esta acción escribiendo exactamente "{{ confirmationWord }}".
      </template>

      <div class="space-y-4">
        <AppAlert variant="warning">
          <p class="font-medium">Se eliminarán datos permanentemente.</p>
          <p class="mt-1 text-sm/6">
            Esta operación borrará la reparación y sus logs. También eliminará la recepción y el dispositivo solo si
            ya no están relacionados con otra reparación.
          </p>
        </AppAlert>

        <div class="rounded-sm border border-slate-200 p-4 text-sm text-slate-600 dark:border-slate-800 dark:text-slate-300">
          <p class="font-medium text-slate-900 dark:text-slate-100">{{ repairLabel }}</p>
          <p class="mt-1">Cliente: {{ clientName }}</p>
          <p class="mt-1">Logs asociados: {{ repair.logs_count ?? 0 }}</p>
        </div>

        <AppInput
          v-model="deleteRepairForm.confirmation"
          label="Escribe Eliminar para confirmar"
          :error="deleteRepairForm.errors.confirmation"
          :hint="`Debes escribir exactamente ${confirmationWord}.`"
          placeholder="Eliminar"
        />
      </div>

      <template #footer>
        <AppButton variant="ghost" :disabled="deleteRepairForm.processing" @click="closeDeleteRepairModal">
          Cancelar
        </AppButton>
        <AppButton
          variant="danger"
          :disabled="deleteRepairDisabled"
          @click="submitDeleteRepair"
        >
          {{ deleteRepairForm.processing ? 'Eliminando...' : 'Eliminar reparación' }}
        </AppButton>
      </template>
    </AppModal>

    <AppModal
      :show="deleteLogsModalOpen"
      title="Eliminar logs"
      @close="closeDeleteLogsModal"
    >
      <template #subtitle>
        Confirma esta acción escribiendo exactamente "{{ confirmationWord }}".
      </template>

      <div class="space-y-4">
        <AppAlert variant="warning">
          <p class="font-medium">Solo se eliminará el historial de logs.</p>
          <p class="mt-1 text-sm/6">
            La reparación seguirá existiendo, pero todos sus logs asociados serán eliminados permanentemente.
          </p>
        </AppAlert>

        <div class="rounded-sm border border-slate-200 p-4 text-sm text-slate-600 dark:border-slate-800 dark:text-slate-300">
          <p class="font-medium text-slate-900 dark:text-slate-100">{{ repairLabel }}</p>
          <p class="mt-1">Logs que se eliminarán: {{ repair.logs_count ?? 0 }}</p>
        </div>

        <AppInput
          v-model="deleteLogsForm.confirmation"
          label="Escribe Eliminar para confirmar"
          :error="deleteLogsForm.errors.confirmation"
          :hint="`Debes escribir exactamente ${confirmationWord}.`"
          placeholder="Eliminar"
        />
      </div>

      <template #footer>
        <AppButton variant="ghost" :disabled="deleteLogsForm.processing" @click="closeDeleteLogsModal">
          Cancelar
        </AppButton>
        <AppButton
          variant="danger"
          :disabled="deleteLogsDisabled"
          @click="submitDeleteLogs"
        >
          {{ deleteLogsForm.processing ? 'Eliminando...' : 'Eliminar logs' }}
        </AppButton>
      </template>
    </AppModal>
  </AppLayout>
</template>

<style scoped>

</style>
