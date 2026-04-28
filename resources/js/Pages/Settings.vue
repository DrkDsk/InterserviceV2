<script setup>
import {reactive, ref} from 'vue';
import AppLayout from '../Layouts/AppLayout.vue';
import AppAlert from '../Components/ui/AppAlert.vue';
import AppButton from '../Components/ui/AppButton.vue';
import AppCard from '../Components/ui/AppCard.vue';
import AppInput from '../Components/ui/AppInput.vue';
import AppSelect from '../Components/ui/AppSelect.vue';
import AppBadge from '../Components/ui/AppBadge.vue';
import {useTheme} from '../composables/useTheme';

const breadcrumbs = [
  {label: 'Home', href: 'dashboard'},
  {label: 'Settings'},
];

const {theme, setTheme} = useTheme();

const settings = reactive({
  name: 'Alex Johnson',
  email: 'alex@interservice.com',
  timezone: 'America/Mexico_City',
  weeklyDigest: true,
  releaseNotes: true,
  alerts: true,
});

const saved = ref(false);

const save = () => {
  saved.value = true;
};
</script>

<template>
  <AppLayout
    title="Settings"
    description="System preferences, profile details, and product defaults."
    :breadcrumbs="breadcrumbs"
  >
    <AppAlert v-if="saved" variant="success">
      <p class="font-medium">Preferences saved.</p>
      <p class="mt-1 text-sm opacity-90">The changes are stored locally in this demo shell.</p>
    </AppAlert>

    <section class="grid gap-4 xl:grid-cols-[1.1fr_0.9fr]">
      <AppCard>
        <div class="border-b border-slate-200 px-5 py-4 dark:border-slate-800">
          <h2 class="text-sm font-semibold text-slate-900 dark:text-slate-100">Profile</h2>
          <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Keep the workspace identity consistent.</p>
        </div>
        <div class="space-y-4 p-5">
          <div class="grid gap-4 sm:grid-cols-2">
            <AppInput v-model="settings.name" label="Full name"/>
            <AppInput v-model="settings.email" label="Email" type="email"/>
          </div>
          <AppSelect v-model="settings.timezone" label="Timezone">
            <option value="America/Mexico_City">America/Mexico_City</option>
            <option value="America/New_York">America/New_York</option>
            <option value="Europe/Madrid">Europe/Madrid</option>
            <option value="UTC">UTC</option>
          </AppSelect>
          <div class="flex flex-wrap gap-3">
            <AppBadge variant="primary">Editable locally</AppBadge>
            <AppBadge variant="success">Ready</AppBadge>
          </div>
        </div>
      </AppCard>

      <AppCard>
        <div class="border-b border-slate-200 px-5 py-4 dark:border-slate-800">
          <h2 class="text-sm font-semibold text-slate-900 dark:text-slate-100">Theme</h2>
          <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">The app uses dark mode via class strategy.</p>
        </div>
        <div class="space-y-4 p-5">
          <button
            type="button"
            class="flex w-full items-center justify-between rounded-sm border px-4 py-3 text-left transition hover:bg-slate-50 dark:hover:bg-slate-900"
            :class="theme === 'light' ? 'border-primary-500/40 bg-primary-500/5' : 'border-slate-200 dark:border-slate-800'"
            @click="setTheme('light')"
          >
            <div>
              <p class="text-sm font-medium text-slate-900 dark:text-slate-100">Light</p>
              <p class="text-xs text-slate-500 dark:text-slate-400">Clean and bright for daytime work.</p>
            </div>
            <span class="h-3 w-3 rounded-full"
                  :class="theme === 'light' ? 'bg-primary-500' : 'bg-slate-300 dark:bg-slate-700'"/>
          </button>

          <button
            type="button"
            class="flex w-full items-center justify-between rounded-sm border px-4 py-3 text-left transition hover:bg-slate-50 dark:hover:bg-slate-900"
            :class="theme === 'dark' ? 'border-primary-500/40 bg-primary-500/5' : 'border-slate-200 dark:border-slate-800'"
            @click="setTheme('dark')"
          >
            <div>
              <p class="text-sm font-medium text-slate-900 dark:text-slate-100">Dark</p>
              <p class="text-xs text-slate-500 dark:text-slate-400">Elegant and low-glare for extended sessions.</p>
            </div>
            <span class="h-3 w-3 rounded-full"
                  :class="theme === 'dark' ? 'bg-primary-500' : 'bg-slate-300 dark:bg-slate-700'"/>
          </button>
        </div>
      </AppCard>
    </section>

    <section class="grid gap-4 xl:grid-cols-2">
      <AppCard>
        <div class="border-b border-slate-200 px-5 py-4 dark:border-slate-800">
          <h2 class="text-sm font-semibold text-slate-900 dark:text-slate-100">Notifications</h2>
          <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Choose what should be surfaced to the team.</p>
        </div>
        <div class="space-y-4 p-5">
          <label
            class="flex items-center justify-between rounded-sm border border-slate-200 px-4 py-3 dark:border-slate-800">
            <div>
              <p class="text-sm font-medium text-slate-900 dark:text-slate-100">Weekly digest</p>
              <p class="text-xs text-slate-500 dark:text-slate-400">Summary of the most important updates.</p>
            </div>
            <input v-model="settings.weeklyDigest" type="checkbox"
                   class="h-4 w-4 rounded-sm border-slate-300 accent-primary-500 focus:ring-primary-500/20 dark:border-slate-700">
          </label>

          <label
            class="flex items-center justify-between rounded-sm border border-slate-200 px-4 py-3 dark:border-slate-800">
            <div>
              <p class="text-sm font-medium text-slate-900 dark:text-slate-100">Release notes</p>
              <p class="text-xs text-slate-500 dark:text-slate-400">Notify the workspace when new versions ship.</p>
            </div>
            <input v-model="settings.releaseNotes" type="checkbox"
                   class="h-4 w-4 rounded-sm border-slate-300 accent-primary-500 focus:ring-primary-500/20 dark:border-slate-700">
          </label>

          <label
            class="flex items-center justify-between rounded-sm border border-slate-200 px-4 py-3 dark:border-slate-800">
            <div>
              <p class="text-sm font-medium text-slate-900 dark:text-slate-100">System alerts</p>
              <p class="text-xs text-slate-500 dark:text-slate-400">Important operational warnings and incidents.</p>
            </div>
            <input v-model="settings.alerts" type="checkbox"
                   class="h-4 w-4 rounded-sm border-slate-300 accent-primary-500 focus:ring-primary-500/20 dark:border-slate-700">
          </label>
        </div>
      </AppCard>

      <AppCard>
        <div class="border-b border-slate-200 px-5 py-4 dark:border-slate-800">
          <h2 class="text-sm font-semibold text-slate-900 dark:text-slate-100">Status</h2>
          <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">A quick summary of your current configuration.</p>
        </div>
        <div class="space-y-4 p-5 text-sm text-slate-600 dark:text-slate-300">
          <p>Theme: <span class="font-medium text-slate-900 dark:text-slate-100">{{ theme }}</span></p>
          <p>Name: <span class="font-medium text-slate-900 dark:text-slate-100">{{ settings.name }}</span></p>
          <p>Email: <span class="font-medium text-slate-900 dark:text-slate-100">{{ settings.email }}</span></p>
          <p>Timezone: <span class="font-medium text-slate-900 dark:text-slate-100">{{ settings.timezone }}</span></p>
          <div class="grid gap-3 sm:grid-cols-3">
            <div class="rounded-sm border border-slate-200 p-4 dark:border-slate-800">
              <p class="text-xs uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Weekly</p>
              <p class="mt-2 text-sm font-medium text-slate-900 dark:text-slate-100">
                {{ settings.weeklyDigest ? 'On' : 'Off' }}</p>
            </div>
            <div class="rounded-sm border border-slate-200 p-4 dark:border-slate-800">
              <p class="text-xs uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Releases</p>
              <p class="mt-2 text-sm font-medium text-slate-900 dark:text-slate-100">
                {{ settings.releaseNotes ? 'On' : 'Off' }}</p>
            </div>
            <div class="rounded-sm border border-slate-200 p-4 dark:border-slate-800">
              <p class="text-xs uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Alerts</p>
              <p class="mt-2 text-sm font-medium text-slate-900 dark:text-slate-100">{{
                  settings.alerts ? 'On' : 'Off'
                }}</p>
            </div>
          </div>
          <AppButton fullWidth @click="save">Save changes</AppButton>
        </div>
      </AppCard>
    </section>
  </AppLayout>
</template>
