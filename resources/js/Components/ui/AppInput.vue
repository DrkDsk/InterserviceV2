<script setup>
import { computed } from 'vue';

const props = defineProps({
    modelValue: {
        type: [String, Number],
        default: '',
    },
    label: {
        type: String,
        default: '',
    },
    type: {
        type: String,
        default: 'text',
    },
    placeholder: {
        type: String,
        default: '',
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

const inputClasses = computed(() => [
    'block w-full rounded-sm border bg-white px-3 py-2 text-sm text-slate-900 transition duration-200 ease-in-out placeholder:text-slate-400 focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/15 dark:border-slate-800 dark:bg-slate-950 dark:text-slate-100 dark:placeholder:text-slate-500',
    props.error ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500/15' : 'border-slate-200',
]);
</script>

<template>
    <label class="block space-y-1.5">
        <span v-if="label" class="text-sm font-medium text-slate-700 dark:text-slate-200">
            {{ label }}<span v-if="required" class="text-rose-500"> *</span>
        </span>
        <input
            :type="type"
            :value="modelValue"
            :placeholder="placeholder"
            :class="inputClasses"
            @input="emits('update:modelValue', $event.target.value)"
            @blur="emits('blur', $event)"
        >
        <span v-if="hint && !error" class="text-xs text-slate-500 dark:text-slate-400">{{ hint }}</span>
        <span v-if="error" class="text-xs text-rose-600 dark:text-rose-300">{{ error }}</span>
    </label>
</template>
