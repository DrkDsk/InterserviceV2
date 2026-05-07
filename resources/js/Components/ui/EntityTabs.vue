<script setup>
import {router} from '@inertiajs/vue3';
import AppBadge from './AppBadge.vue';
import AppIcon from '../AppIcon.vue';

defineProps({
  items: {
    type: Array,
    default: () => [],
  },
});

const navigate = (href) => {
  if (!href) {
    return;
  }

  router.visit(href);
};
</script>

<template>
  <nav class="overflow-x-auto" aria-label="Navegación contextual">
    <div class="flex min-w-max items-center gap-1">
      <button
        v-for="(item, index) in items"
        :key="`${item.label}-${index}`"
        type="button"
        class="group inline-flex items-center gap-2 border-b-2 px-3 py-3 text-sm font-medium whitespace-nowrap transition-colors"
        :class="item.active
          ? 'border-primary-500 text-slate-900 dark:text-slate-100'
          : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-900 dark:text-slate-400 dark:hover:border-slate-700 dark:hover:text-slate-100'"
        @click="navigate(item.href)"
      >
        <AppIcon
          v-if="item.icon"
          :name="item.icon"
          class="h-4 w-4"
          :class="item.active
            ? 'text-primary-500 dark:text-primary-300'
            : 'text-slate-400 transition-colors group-hover:text-slate-600 dark:text-slate-500 dark:group-hover:text-slate-300'"
        />
        <span>{{ item.label }}</span>
        <AppBadge
          v-if="item.badge !== undefined && item.badge !== null"
          :variant="item.active ? 'primary' : 'neutral'"
        >
          {{ item.badge }}
        </AppBadge>
      </button>
    </div>
  </nav>
</template>
