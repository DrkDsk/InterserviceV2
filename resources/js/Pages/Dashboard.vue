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
        <section class="dashboard-card">
            <p class="eyebrow">Inertia + Vue 3</p>
            <h1>Dashboard</h1>
            <p class="lead">{{ message }}</p>

            <div class="grid">
                <article class="tile">
                    <span class="label">Framework</span>
                    <strong>Laravel</strong>
                </article>
                <article class="tile">
                    <span class="label">Frontend</span>
                    <strong>Vue 3 + Inertia</strong>
                </article>
                <article class="tile">
                    <span class="label">Database</span>
                    <strong>MySQL</strong>
                </article>
            </div>
        </section>
    </AppLayout>
</template>

<style scoped>
.dashboard-card {
    background: var(--panel);
    border: 1px solid var(--panel-border);
    border-radius: 28px;
    padding: 40px;
    box-shadow: var(--shadow);
}

.eyebrow {
    margin: 0 0 12px;
    color: var(--accent);
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    font-size: 0.75rem;
}

h1 {
    margin: 0;
    font-size: clamp(2rem, 4vw, 3.5rem);
    line-height: 1;
}

.lead {
    margin: 16px 0 0;
    color: var(--muted);
    font-size: 1.05rem;
    max-width: 56ch;
}

.grid {
    margin-top: 32px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 16px;
}

.tile {
    padding: 20px;
    border-radius: 20px;
    background: rgba(15, 118, 110, 0.06);
    border: 1px solid rgba(15, 118, 110, 0.12);
}

.label {
    display: block;
    color: var(--muted);
    font-size: 0.85rem;
    margin-bottom: 8px;
}

strong {
    font-size: 1.05rem;
}
</style>

