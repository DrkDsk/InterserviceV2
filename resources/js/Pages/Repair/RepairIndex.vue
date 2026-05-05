<script setup>

import AppLayout from "../../Layouts/AppLayout.vue";
import AppButton from "../../Components/ui/AppButton.vue";
import {router} from '@inertiajs/vue3'
import {route} from 'ziggy-js'
import AppTable from "@/Components/ui/AppTable.vue";
import EmptyState from "@/Components/ui/EmptyState.vue";
import AppBadge from "@/Components/ui/AppBadge.vue";

const props = defineProps({
  repairs: {
    type: Object,
    default: () => [],
  },
})

const receptionsFiltered = props.repairs.data

const columns = [
  {key: 'id', label: 'ID'},
  {key: 'issue', label: 'Problema'},
  {key: 'technician', label: 'Técnico'},
  {key: 'client', label: 'Cliente'},
  {key: 'customer_phone', label: 'Número Telefónico Cliente'},
  {key: 'status', label: 'Estatus'},
  {key: 'actions', label: 'Acciones'},
];

const breadcrumbs = [
  {label: 'Home', href: 'dashboard'},
  {label: 'Reparaciones'},
];

const onCreateReception = () => {
  router.visit(route('repairs.create'));
}

const handleAssignUpdating = (id) => {
  console.log('id', id)
  /*router.visit(route('repairs.update', id));*/
}

</script>

<template>
  <AppLayout
    title="Reparaciones"
    description="Gestionar reparaciones"
    :breadcrumbs="breadcrumbs"
  >
    <div class="flex flex-col gap-4">
      <AppButton @click="onCreateReception" variant="primary" key="registrar-recepcion" class="py-12 w-full">
        <span class="text-xl lg:text-lg md:text-md">Registrar Recepcion</span>
      </AppButton>
    </div>

    <AppTable
      title="Lista de reparaciones"
      description="Buscar y filtrar reparaciones registradas."
      :columns="columns"
      :rows="receptionsFiltered"
      :searchableKeys="['folio']"
      searchPlaceholder="Busca nombre, número telefónico, etc."
      rowKey="id">
      <template #cell-status="{ value }">
        <AppBadge :variant="value === 'completed' ? 'success' : value === 'in_progress' ? 'primary' : 'warning'">
          {{ value }}
        </AppBadge>
      </template>
      <template #cell-actions="{ value }">
        <AppButton variant="outline" size="sm" class="mr-2" @click="handleAssignUpdating()">
          Actualizar proceso
        </AppButton>
      </template>
      <template #empty>
        <EmptyState
          title="No hay reparaciones registradas"
          description="Intenta limpiar los parámetros de búsqueda o limpia los filtros"
          icon="fa-table-cells"
        />
      </template>
    </AppTable>
  </AppLayout>
</template>

<style scoped>

</style>
