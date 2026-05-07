<script setup>
import {computed, onBeforeUnmount, ref, watch} from 'vue';
import {usePage} from '@inertiajs/vue3';
import AppIcon from '../AppIcon.vue';

const page = usePage();
const toasts = ref([]);
let toastId = 1;

const flash = computed(() => page.props.flash ?? {});

const pushToast = (message, type = 'info') => {
  if (!message) {
    return;
  }

  const id = toastId++;
  toasts.value.push({id, message, type});

  window.setTimeout(() => {
    toasts.value = toasts.value.filter((toast) => toast.id !== id);
  }, 4000);
};

watch(
  () => [flash.value.success, flash.value.error, flash.value.info],
  ([success, error, info]) => {
    if (success) {
      pushToast(success, 'success');
    }

    if (error) {
      pushToast(error, 'error');
    }

    if (info) {
      pushToast(info);
    }
  },
  {immediate: true},
);

onBeforeUnmount(() => {
  toasts.value = [];
});

const variants = {
  success: 'border-success-200 bg-[var(--surface-strong)] text-slate-900 dark:border-success-400/20 dark:text-slate-100',
  error: 'border-danger-200 bg-[var(--surface-strong)] text-slate-900 dark:border-danger-400/20 dark:text-slate-100',
  info: 'border-primary-200 bg-[var(--surface-strong)] text-slate-900 dark:border-primary-400/20 dark:text-slate-100',
};
</script>

<template>
  <div class="fixed right-4 top-4 z-50 flex w-[calc(100vw-2rem)] max-w-sm flex-col gap-3 sm:right-6 sm:top-6">
    <TransitionGroup
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="translate-y-2 opacity-0"
      enter-to-class="translate-y-0 opacity-100"
      leave-active-class="transition duration-150 ease-in"
      leave-from-class="translate-y-0 opacity-100"
      leave-to-class="-translate-y-2 opacity-0"
    >
      <div
        v-for="toast in toasts"
        :key="toast.id"
        class="rounded-2xl border px-4 py-3 shadow-panel backdrop-blur-xl"
        :class="variants[toast.type] ?? variants.info"
      >
        <div class="flex items-start gap-3">
          <div
            class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-xl"
            :class="toast.type === 'success' ? 'bg-success-100 text-success-600 dark:bg-success-500/14 dark:text-success-300' : toast.type === 'error' ? 'bg-danger-100 text-danger-600 dark:bg-danger-500/14 dark:text-danger-300' : 'bg-primary-100 text-primary-600 dark:bg-primary-500/14 dark:text-primary-300'"
          >
            <AppIcon :name="toast.type === 'success' ? 'fa-gauge-high' : 'fa-bell'" class="h-4 w-4"/>
          </div>
          <div class="min-w-0 flex-1">
            <p class="text-sm font-medium text-slate-900 dark:text-slate-100">
              {{ toast.message }}
            </p>
          </div>
        </div>
      </div>
    </TransitionGroup>
  </div>
</template>
