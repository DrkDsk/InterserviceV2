<script setup>

import AppLayout from "../../Layouts/AppLayout.vue";
import AppButton from "../../Components/ui/AppButton.vue";
import {router} from '@inertiajs/vue3'
import {route} from 'ziggy-js'
import AppTable from "@/Components/ui/AppTable.vue";

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
];

const breadcrumbs = [
  {label: 'Home', href: 'dashboard'},
  {label: 'Reparaciones'},
];

const onCreateReception = () => {
  router.visit(route('repairs.create'));
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
    </AppTable>
  </AppLayout>
</template>

<style scoped>

</style>
