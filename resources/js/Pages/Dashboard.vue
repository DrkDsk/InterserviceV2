<script setup>
import AppLayout from '../Layouts/AppLayout.vue';

defineProps({
    message: {
        type: String,
        default: 'Welcome to interservice.',
    },
    stats: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <AppLayout>
        <section
            class="mx-auto flex w-full max-w-4xl flex-col gap-8 rounded-3xl bg-white/90 p-8 text-center shadow-2xl shadow-slate-900/10 ring-1 ring-slate-200/80 backdrop-blur sm:p-12"
        >
            <div class="mx-auto inline-flex items-center gap-2 rounded-full bg-teal-50 px-4 py-2 text-sm font-semibold text-teal-700 ring-1 ring-teal-100">
                <span class="h-2 w-2 rounded-full bg-teal-500"></span>
                Inertia + Vue 3
            </div>

            <div class="space-y-4">
                <h1 class="text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl">
                    Dashboard
                </h1>
                <p class="mx-auto max-w-2xl text-base leading-7 text-slate-600 sm:text-lg">
                    {{ message }}
                </p>
            </div>

            <div class="grid gap-4 sm:grid-cols-3">
                <article class="rounded-2xl border border-teal-100 bg-teal-50/70 p-5 text-left">
                    <span class="block text-sm font-medium text-slate-500">Framework</span>
                    <strong class="mt-2 block text-lg text-slate-900">Laravel</strong>
                </article>
                <article class="rounded-2xl border border-teal-100 bg-teal-50/70 p-5 text-left">
                    <span class="block text-sm font-medium text-slate-500">Frontend</span>
                    <strong class="mt-2 block text-lg text-slate-900">Vue 3 + Inertia</strong>
                </article>
                <article class="rounded-2xl border border-teal-100 bg-teal-50/70 p-5 text-left">
                    <span class="block text-sm font-medium text-slate-500">Database</span>
                    <strong class="mt-2 block text-lg text-slate-900">MySQL</strong>
                </article>
            </div>

            <div>
                <button
                    type="button"
                    class="inline-flex items-center justify-center rounded-full bg-teal-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-teal-600/25 transition hover:-translate-y-0.5 hover:bg-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2"
                >
                    Tailwind is working
                </button>
            </div>
        </section>
    </AppLayout>
</template>
