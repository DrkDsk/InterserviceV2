<script setup>
import {onBeforeUnmount, onMounted, watch} from 'vue';
import AppIcon from '../AppIcon.vue';

const props = defineProps({
  show: {
    type: Boolean,
    default: false,
  },
  title: {
    type: String,
    default: '',
  },
});

const emits = defineEmits(['close']);

const handleKeydown = (event) => {
  if (event.key === 'Escape') {
    emits('close');
  }
};

onMounted(() => {
  window.addEventListener('keydown', handleKeydown);
});

onBeforeUnmount(() => {
  window.removeEventListener('keydown', handleKeydown);
  document.body.style.overflow = '';
});

watch(
  () => props.show,
  (visible) => {
    document.body.style.overflow = visible ? 'hidden' : '';
  },
  {immediate: true},
);
</script>

<template>
  <Teleport to="body">
    <Transition
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition duration-150 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center px-4 py-6">
        <button
          type="button"
          class="absolute inset-0 bg-slate-950/60 backdrop-blur-[1px]"
          @click="emits('close')"
        />

        <Transition
          enter-active-class="transition duration-200 ease-out"
          enter-from-class="translate-y-4 scale-[0.98] opacity-0"
          enter-to-class="translate-y-0 scale-100 opacity-100"
          leave-active-class="transition duration-150 ease-in"
          leave-from-class="translate-y-0 scale-100 opacity-100"
          leave-to-class="translate-y-4 scale-[0.98] opacity-0"
        >
          <div
            class="ui-panel-strong relative z-10 w-full max-w-2xl rounded-[1.35rem] shadow-floating">
            <div class="ui-divider flex items-center justify-between border-b px-5 py-4">
              <div>
                <h3 class="text-base font-semibold text-slate-900 dark:text-slate-100">
                  {{ title }}
                </h3>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                  <slot name="subtitle"/>
                </p>
              </div>
              <button
                type="button"
                class="ui-toolbar-button rounded-xl p-2 transition"
                @click="emits('close')"
              >
                <AppIcon name="fa-xmark" class="h-4 w-4"/>
              </button>
            </div>

            <div class="max-h-[75vh] overflow-y-auto px-5 py-5">
              <slot/>
            </div>

            <div v-if="$slots.footer"
                 class="ui-divider flex items-center justify-end gap-3 border-t px-5 py-4">
              <slot name="footer"/>
            </div>
          </div>
        </Transition>
      </div>
    </Transition>
  </Teleport>
</template>
