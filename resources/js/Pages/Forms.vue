<script setup>
import { computed, reactive, ref } from 'vue';
import AppLayout from '../Layouts/AppLayout.vue';
import AppAlert from '../Components/ui/AppAlert.vue';
import AppButton from '../Components/ui/AppButton.vue';
import AppCard from '../Components/ui/AppCard.vue';
import AppInput from '../Components/ui/AppInput.vue';
import AppSelect from '../Components/ui/AppSelect.vue';
import AppTextarea from '../Components/ui/AppTextarea.vue';
import AppBadge from '../Components/ui/AppBadge.vue';

const breadcrumbs = [
    { label: 'Home', href: '/dashboard' },
    { label: 'Forms' },
];

const form = reactive({
    name: '',
    email: '',
    company: '',
    role: '',
    budget: '',
    message: '',
});

const errors = reactive({
    name: '',
    email: '',
    company: '',
    role: '',
    budget: '',
    message: '',
});

const submitted = ref(false);
const hasErrors = computed(() => Object.values(errors).some(Boolean));

const validate = () => {
    errors.name = form.name.trim() ? '' : 'Please enter a contact name.';
    errors.email = /^\S+@\S+\.\S+$/.test(form.email) ? '' : 'Enter a valid email address.';
    errors.company = form.company.trim() ? '' : 'Company is required.';
    errors.role = form.role ? '' : 'Select a role.';
    errors.budget = form.budget ? '' : 'Choose a budget range.';
    errors.message = form.message.trim().length >= 20 ? '' : 'Tell us a bit more about the project.';

    return !hasErrors.value;
};

const submit = () => {
    submitted.value = validate();
};

const budgetOptions = [
    { label: 'Under $5k', value: 'under-5k' },
    { label: '$5k - $15k', value: '5k-15k' },
    { label: '$15k - $50k', value: '15k-50k' },
    { label: '$50k+', value: '50k-plus' },
];

const roles = ['Product', 'Engineering', 'Operations', 'Finance', 'Founder'];

const completeness = computed(() => {
    const fields = [form.name, form.email, form.company, form.role, form.budget, form.message];
    const filled = fields.filter((value) => String(value).trim().length > 0).length;
    return Math.round((filled / fields.length) * 100);
});
</script>

<template>
    <AppLayout
        title="Forms"
        description="Clean inputs, gentle focus states, and practical validation."
        :breadcrumbs="breadcrumbs"
    >
        <section class="grid gap-4 xl:grid-cols-[1.2fr_0.8fr]">
            <AppCard>
                <div class="border-b border-slate-200 px-5 py-4 dark:border-slate-800">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Lead intake</p>
                    <h2 class="mt-2 text-lg font-semibold text-slate-900 dark:text-slate-100">Request a project consultation</h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">A compact form with basic client-side validation.</p>
                </div>
                <form class="space-y-5 p-5" @submit.prevent="submit">
                    <div class="grid gap-4 sm:grid-cols-2">
                        <AppInput v-model="form.name" label="Name" placeholder="Alex Johnson" :error="errors.name" required />
                        <AppInput v-model="form.email" label="Email" type="email" placeholder="alex@company.com" :error="errors.email" required />
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <AppInput v-model="form.company" label="Company" placeholder="Interservice" :error="errors.company" required />
                        <AppSelect v-model="form.role" label="Role" :error="errors.role">
                            <option disabled value="">Select a role</option>
                            <option v-for="role in roles" :key="role" :value="role">{{ role }}</option>
                        </AppSelect>
                    </div>

                    <AppSelect v-model="form.budget" label="Budget range" :error="errors.budget">
                        <option disabled value="">Select budget</option>
                        <option v-for="option in budgetOptions" :key="option.value" :value="option.value">
                            {{ option.label }}
                        </option>
                    </AppSelect>

                    <AppTextarea
                        v-model="form.message"
                        label="Project details"
                        :rows="5"
                        placeholder="Share the context, outcomes, and any constraints."
                        :error="errors.message"
                    />

                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <AppBadge variant="primary">{{ completeness }}% complete</AppBadge>
                            <span class="text-sm text-slate-500 dark:text-slate-400">Validation runs locally in the browser.</span>
                        </div>
                        <AppButton type="submit">Submit request</AppButton>
                    </div>
                </form>
            </AppCard>

            <div class="space-y-4">
                <AppAlert v-if="submitted && !hasErrors" variant="success">
                    <p class="font-medium">Form ready.</p>
                    <p class="mt-1 text-sm opacity-90">Your request passed the basic validation rules.</p>
                </AppAlert>

                <AppAlert v-if="submitted && hasErrors" variant="danger">
                    <p class="font-medium">Please review the form.</p>
                    <p class="mt-1 text-sm opacity-90">A few fields still need attention before submission.</p>
                </AppAlert>

                <AppCard>
                    <div class="border-b border-slate-200 px-5 py-4 dark:border-slate-800">
                        <h3 class="text-sm font-semibold text-slate-900 dark:text-slate-100">Live payload preview</h3>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Useful for QA or demos during implementation.</p>
                    </div>
                    <pre class="overflow-x-auto p-5 text-xs leading-6 text-slate-600 dark:text-slate-300">{{ JSON.stringify({
    name: form.name,
    email: form.email,
    company: form.company,
    role: form.role,
    budget: form.budget,
    messageLength: form.message.length,
}, null, 2) }}</pre>
                </AppCard>

                <AppCard>
                    <div class="p-5">
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">UX notes</p>
                        <ul class="mt-3 space-y-3 text-sm text-slate-600 dark:text-slate-300">
                            <li>Thin borders keep the form lightweight.</li>
                            <li>Primary focus ring is soft but visible.</li>
                            <li>Error states stay restrained and readable.</li>
                        </ul>
                    </div>
                </AppCard>
            </div>
        </section>
    </AppLayout>
</template>
