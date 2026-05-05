<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import AppCard from "@/Components/ui/AppCard.vue";
import {ref} from "vue";
import AppTextarea from "@/Components/ui/AppTextarea.vue";
import AppIcon from "@/Components/AppIcon.vue";
import AppButton from "@/Components/ui/AppButton.vue";
import {router} from "@inertiajs/vue3";
import {route} from "ziggy-js"

const props = defineProps({
  repair: {
    type: Object,
    default: () => {
    },
  }
})

const breadcrumbs = [
  {label: 'Home', href: 'dashboard'},
  {label: 'Reparación', href: 'repairs.edit', params: {id: props.repair.id}},
  {label: 'Historial', current: true},
];

const logs = ref(props.repair.logs ?? [])

const removeLog = (id) => {
  logs.value = logs.value.filter(log => log.id !== id);
}

const addLog = () => {
  logs.value.push({
    id: null,
    message: '',
  })
}

const upsertLog = (id, message) => {
  if (id == null) {
    router.post(route("repairs.logs.store", props.repair.id), {
      message
    })
  } else {
    router.put(route("repairs.logs.update", id), {
      message
    })
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
          </section>
        </div>
      </AppCard>
    </div>
  </AppLayout>
</template>

<style scoped>

</style>
