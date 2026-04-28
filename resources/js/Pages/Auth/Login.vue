<script setup>
import {computed, reactive, ref} from 'vue';
import {Head, router, usePage} from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import AppCard from '@/Components/ui/AppCard.vue';
import AppButton from '@/Components/ui/AppButton.vue';
import AppInput from '@/Components/ui/AppInput.vue';
import AppAlert from '@/Components/ui/AppAlert.vue';

const form = reactive({
  email: '',
  password: '',
});

const loading = ref(false);
const frontendErrors = reactive({
  email: '',
  password: '',
});

const page = usePage();
const backendErrors = computed(() => page.props.errors ?? {});
const statusMessage = computed(() => page.props.status ?? '');

const resetFrontendErrors = () => {
  frontendErrors.email = '';
  frontendErrors.password = '';
};

const validate = () => {
  resetFrontendErrors();

  let isValid = true;

  if (!form.email.trim()) {
    frontendErrors.email = 'Ingresa tu correo.';
    isValid = false;
  } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email)) {
    frontendErrors.email = 'Ingresa un correo valido.';
    isValid = false;
  }

  if (!form.password) {
    frontendErrors.password = 'Ingresa tu contrasena.';
    isValid = false;
  }

  return isValid;
};

const submit = async () => {
  if (loading.value || !validate()) {
    return;
  }

  loading.value = true;

  try {
    await window.axios.get(route('sanctum.csrf-cookie'));

    router.post(route('login.store'), form, {
      onFinish: () => {
        loading.value = false;
      },
    });
  } catch (error) {
    loading.value = false;
    frontendErrors.email = 'No fue posible iniciar la sesion. Intenta de nuevo.';
  }
};
</script>

<template>
  <Head title="Iniciar sesion"/>

  <AppLayout
    title="Iniciar sesion"
    description="Accede a tu cuenta para continuar en el sistema."
    :show-navigation="false"
  >
    <div class="flex flex-1 items-center justify-center py-8 sm:py-12">
      <AppCard class="w-full max-w-md p-6 sm:p-8">
        <div class="space-y-6">
          <div class="space-y-2">
            <h2 class="text-xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">
              Bienvenido de nuevo
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">
              Inicia sesion con tu correo y contrasena.
            </p>
          </div>

          <AppAlert v-if="statusMessage" variant="success">
            {{ statusMessage }}
          </AppAlert>

          <form class="space-y-4" @submit.prevent="submit">
            <AppInput
              v-model="form.email"
              type="email"
              label="Correo electronico"
              placeholder="tu@empresa.com"
              required
              :error="frontendErrors.email || backendErrors.email"
            />

            <AppInput
              v-model="form.password"
              type="password"
              label="Contrasena"
              placeholder="Ingresa tu contrasena"
              required
              :error="frontendErrors.password || backendErrors.password"
            />

            <AppButton type="submit" :disabled="loading" :full-width="true">
              {{ loading ? 'Ingresando...' : 'Iniciar sesion' }}
            </AppButton>
          </form>
        </div>
      </AppCard>
    </div>
  </AppLayout>
</template>
