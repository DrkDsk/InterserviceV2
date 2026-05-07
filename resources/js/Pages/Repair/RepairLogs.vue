<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import AppCard from "@/Components/ui/AppCard.vue";
import {ref, watch} from "vue";
import AppTextarea from "@/Components/ui/AppTextarea.vue";
import AppIcon from "@/Components/AppIcon.vue";
import AppButton from "@/Components/ui/AppButton.vue";
import {router} from "@inertiajs/vue3";
import {route} from "ziggy-js"
import EmptyState from "@/Components/ui/EmptyState.vue";

const props = defineProps({
  repair: {
    type: Object,
    default: () => {
    },
  }
})

const options = {
  preserveScroll: true,
}

const breadcrumbs = [
  {label: 'Home', href: 'dashboard'},
  {label: 'Reparación', href: 'repairs.edit', params: {id: props.repair.id}},
  {label: 'Historial', current: true},
];

const logs = ref([])

watch(
  () => props.repair.logs,
  (newLogs) => {
    logs.value = [...newLogs]
  },
  {immediate: true}
)

const removeLog = (id) => {
  router.delete(route("repairs.logs.destroy", id), options)
}

const addLog = () => {
  logs.value.push({
    id: null,
    message: '',
  })
}

const upsertLog = (id, message) => {
  if (id == null) {
    router.post(route("repairs.logs.store", props.repair.id), {message}, options)
  } else {
    router.put(route("repairs.logs.update", id), {message}, options)
  }
}

</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="mx-auto w-full space-y-4">
      <AppCard class="overflow-hidden">
        <div class="px-6 py-6 sm:px-8">
          <section class="space-y-6">
            <AppButton @click="addLog">
              <AppIcon name="fa-plus"/>
            </AppButton>

            <div v-for="(log, index) in logs" :key="log.id" class="flex">
              <div class="flex items-center gap-3 w-full">
                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">{{ index + 1 }}</span>
                <AppTextarea class="w-10/12" v-model="log.message" :rows="1"/>
                <AppIcon @click="removeLog(log.id)" class="text-red-400 cursor-pointer" name="fa-trash"/>
                <AppIcon @click="upsertLog(log.id, log.message)" class="text-green-200 cursor-pointer"
                         name="fa-circle-check"/>
              </div>
            </div>

            <template v-if="logs.length === 0">
              <EmptyState
                title="No hay reparaciones registradas"
                icon="fa-screwdriver-wrench"
              />
            </template>
          </section>
        </div>
      </AppCard>
    </div>
  </AppLayout>
</template>

<style scoped>

</style>
