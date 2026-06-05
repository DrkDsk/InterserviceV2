<script setup>
import {computed, ref, watch} from 'vue';
import AppIcon from '../AppIcon.vue';

const props = defineProps({
  title: {
    type: String,
    default: '',
  },
  description: {
    type: String,
    default: '',
  },
  columns: {
    type: Array,
    default: () => [],
  },
  rows: {
    type: Array,
    default: () => [],
  },
  searchableKeys: {
    type: Array,
    default: () => [],
  },
  searchPlaceholder: {
    type: String,
    default: 'Search...',
  },
  itemsPerPage: {
    type: Number,
    default: 5,
  },
  rowKey: {
    type: String,
    default: 'id',
  },
});

const query = ref('');
const currentPage = ref(1);

const searchKeys = computed(() => (props.searchableKeys.length ? props.searchableKeys : props.columns.map((column) => column.key)));

const filteredRows = computed(() => {
  const term = query.value.trim().toLowerCase();

  if (!term) {
    return props.rows;
  }

  return props.rows.filter((row) =>
    searchKeys.value.some((key) => String(row[key] ?? '').toLowerCase().includes(term)),
  );
});

const totalPages = computed(() => Math.max(1, Math.ceil(filteredRows.value.length / props.itemsPerPage)));

const paginatedRows = computed(() => {
  const start = (currentPage.value - 1) * props.itemsPerPage;
  return filteredRows.value.slice(start, start + props.itemsPerPage);
});

const rangeLabel = computed(() => {
  if (!filteredRows.value.length) {
    return '0 results';
  }

  const start = (currentPage.value - 1) * props.itemsPerPage + 1;
  const end = Math.min(currentPage.value * props.itemsPerPage, filteredRows.value.length);

  return `${start}-${end} of ${filteredRows.value.length}`;
});

watch(query, () => {
  currentPage.value = 1;
});

watch(filteredRows, () => {
  if (currentPage.value > totalPages.value) {
    currentPage.value = totalPages.value;
  }
});

const setPage = (page) => {
  currentPage.value = Math.min(Math.max(page, 1), totalPages.value);
};
</script>

<template>
  <section
    class="ui-panel overflow-hidden rounded-2xl">
    <div
      class="ui-divider flex flex-col gap-4 border-b px-5 py-4 lg:flex-row lg:items-center lg:justify-between">
      <div class="space-y-1">
        <h2 v-if="title" class="text-sm font-semibold text-slate-900 dark:text-slate-100">
          {{ title }}
        </h2>
        <p v-if="description" class="text-sm text-slate-500 dark:text-slate-400">
          {{ description }}
        </p>
      </div>

      <label class="relative w-full max-w-sm">
        <AppIcon name="fa-magnifying-glass"
                 class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"/>
        <input
          v-model="query"
          type="search"
          :placeholder="searchPlaceholder"
          class="ui-control w-full rounded-xl py-2.5 pl-9 pr-3 text-sm"
        >
      </label>
    </div>

    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-(--border)">
        <thead class="bg-(--surface-muted)">
        <tr>
          <th
            v-for="column in columns"
            :key="column.key"
            class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-500 dark:text-slate-400"
          >
            {{ column.label }}
          </th>
        </tr>
        </thead>
        <tbody class="divide-y divide-(--border)">
        <tr v-if="!paginatedRows.length">
          <td :colspan="columns.length" class="px-5 py-10 text-center text-sm text-slate-500 dark:text-slate-400">
            <slot name="empty">
              No matches found.
            </slot>
          </td>
        </tr>
        <tr
          v-for="row in paginatedRows"
          :key="row[rowKey]"
          class="transition hover:bg-(--primary-soft)"
        >
          <td
            v-for="column in columns"
            :key="column.key"
            class="whitespace-nowrap px-5 py-4 text-sm text-slate-700 dark:text-slate-200"
            :class="column.className"
          >
            <slot
              :name="`cell-${column.key}`"
              :row="row"
              :value="row[column.key]"
              :column="column"
            >
              {{ row[column.key] }}
            </slot>
          </td>
        </tr>
        </tbody>
      </table>
    </div>

    <div
      class="ui-divider flex flex-col gap-4 border-t px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
      <p class="text-sm text-slate-500 dark:text-slate-400">
        {{ rangeLabel }}
      </p>
      <div class="flex items-center gap-2">
        <button
          type="button"
          class="ui-toolbar-button inline-flex h-9 w-9 items-center justify-center rounded-xl transition disabled:opacity-40"
          :disabled="currentPage === 1"
          @click="setPage(currentPage - 1)"
        >
          <AppIcon name="fa-chevron-left" class="h-4 w-4"/>
        </button>
        <span class="min-w-20 text-center text-sm text-slate-600 dark:text-slate-300">
                    {{ currentPage }} / {{ totalPages }}
                </span>
        <button
          type="button"
          class="ui-toolbar-button inline-flex h-9 w-9 items-center justify-center rounded-xl transition disabled:opacity-40"
          :disabled="currentPage === totalPages"
          @click="setPage(currentPage + 1)"
        >
          <AppIcon name="fa-chevron-right" class="h-4 w-4"/>
        </button>
      </div>
    </div>
  </section>
</template>
