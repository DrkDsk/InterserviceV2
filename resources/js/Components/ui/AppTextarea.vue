<script setup>
import {computed} from 'vue';

const props = defineProps({
  modelValue: {
    type: [String, Number],
    default: '',
  },
  label: {
    type: String,
    default: '',
  },
  rows: {
    type: Number,
    default: 4,
  },
  error: {
    type: String,
    default: '',
  },
  hint: {
    type: String,
    default: '',
  },
  required: {
    type: Boolean,
    default: false,
  },
});

const emits = defineEmits(['update:modelValue', 'blur']);

const classes = computed(() => [
  'ui-control block rounded-xl px-3.5 py-2.5 text-sm transition duration-200 ease-in-out',
  props.error ? 'border-danger-400 focus:border-danger-500 focus:ring-4 focus:ring-danger-500/15' : '',
]);
</script>

<template>
  <label class="block space-y-1.5">
    <span v-if="label" class="ui-label text-sm font-medium">
      {{ label }}<span v-if="required" class="text-danger-500"> *</span>
    </span>
    <textarea
      :rows="rows"
      :value="modelValue"
      :class="classes"
      @input="emits('update:modelValue', $event.target.value)"
      @blur="emits('blur', $event)"
    />
    <span v-if="hint && !error" class="ui-hint text-xs">{{ hint }}</span>
    <span v-if="error" class="text-xs text-danger-600 dark:text-danger-300">{{ error }}</span>
  </label>
</template>
