<script setup>
import {router} from '@inertiajs/vue3'
import AppIcon from '../AppIcon.vue';
import {route} from 'ziggy-js'

const props = defineProps({
  href: {
    type: String,
    required: true,
  },
  icon: {
    type: String,
    required: true,
  },
  label: {
    type: String,
    required: true,
  },
  active: {
    type: Boolean,
    default: false,
  },
  collapsed: {
    type: Boolean,
    default: false,
  },
});

const navigate = () => {
  router.visit(route(props.href))
}
</script>

<template>
  <div
    @click="navigate()"
    :title="collapsed ? label : undefined"
    class="group relative flex items-center gap-3 rounded-2xl px-3 py-2.5 text-sm transition-all duration-200 ease-in-out"
    :class="active
            ? 'bg-primary-50/85 text-slate-900 shadow-soft dark:bg-primary-500/12 dark:text-white'
            : 'text-slate-600 hover:bg-white/60 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-white/4 dark:hover:text-slate-100'"
  >
        <span
          v-if="active"
          class="absolute inset-y-2 left-0 w-0.5 rounded-full bg-primary-500"
        />

    <span
      class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-[color:var(--border)] bg-[var(--surface)] text-slate-500 transition group-hover:border-[color:var(--border-strong)] group-hover:text-slate-700 dark:text-slate-400 dark:group-hover:text-slate-200"
      :class="active ? 'border-primary-200 bg-primary-50 text-primary-600 dark:border-primary-400/20 dark:bg-primary-500/14 dark:text-primary-200' : ''">
            <AppIcon :name="icon" class="h-6 w-6"/>
        </span>

    <span class="truncate transition-all duration-200 ease-in-out"
          :class="collapsed ? 'max-w-0 opacity-0' : 'max-w-45 opacity-100'">
            {{ label }}
        </span>
  </div>
</template>
