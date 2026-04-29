<script setup>
import {computed, onBeforeUnmount, onMounted, ref, watch} from 'vue';
import {router, usePage} from '@inertiajs/vue3';
import AppIcon from '../Components/AppIcon.vue';
import AppButton from '../Components/ui/AppButton.vue';
import AppModal from '../Components/ui/AppModal.vue';
import Breadcrumbs from '../Components/ui/Breadcrumbs.vue';
import SidebarNavItem from '../Components/ui/SidebarNavItem.vue';
import ToastStack from '../Components/ui/ToastStack.vue';
import {useTheme} from '../composables/useTheme';

const props = defineProps({
  title: {
    type: String,
    default: 'Dashboard',
  },
  description: {
    type: String,
    default: '',
  },
  breadcrumbs: {
    type: Array,
    default: () => [],
  },
  showNavigation: {
    type: Boolean,
    default: true,
  },
});

const page = usePage();
const {isDark, toggleTheme} = useTheme();

const sidebarKey = 'interservice-sidebar-collapsed';
const mobileSidebarOpen = ref(false);
const collapsedSidebar = ref(typeof window !== 'undefined' && window.localStorage.getItem(sidebarKey) === '1');
const profileMenuOpen = ref(false);
const profileMenuRef = ref(null);
const logoutModalOpen = ref(false);

const appName = computed(() => page.props.appName ?? 'Interservice');
const currentPath = computed(() => page.url.split('?')[0] || '/');
const isAuthenticated = computed(() => Boolean(page.props.auth?.user));
const displayNavigation = computed(() => props.showNavigation && isAuthenticated.value);
const userName = computed(() => page.props.auth?.user?.name ?? 'Admin');

const navItems = [
  {label: 'Dashboard', href: 'dashboard', icon: 'fa-gauge-high'},
  {label: 'Tables', href: 'tables', icon: 'fa-table-cells'},
  {label: 'Forms', href: 'forms', icon: 'fa-file'},
  {label: 'Charts', href: 'charts', icon: 'fa-chart-pie'},
  {label: 'UI Components', href: 'components', icon: 'fa-brands fa-vuejs'},
  {label: 'Settings', href: 'settings', icon: 'fa-gear'},
  {label: 'Reparaciones', href: 'repairs.index', icon: 'fa-screwdriver-wrench'},
];

const isActive = (href) => currentPath.value === href;

watch(collapsedSidebar, (value) => {
  if (typeof window !== 'undefined') {
    window.localStorage.setItem(sidebarKey, value ? '1' : '0');
  }
});

watch(currentPath, () => {
  mobileSidebarOpen.value = false;
  profileMenuOpen.value = false;
  logoutModalOpen.value = false;
});

const sidebarWidthClass = computed(() => (collapsedSidebar.value ? 'lg:w-20' : 'lg:w-72'));

const toggleProfileMenu = () => {
  profileMenuOpen.value = !profileMenuOpen.value;
};

const closeProfileMenu = () => {
  profileMenuOpen.value = false;
};

const openLogoutModal = () => {
  closeProfileMenu();
  logoutModalOpen.value = true;
};

const closeLogoutModal = () => {
  logoutModalOpen.value = false;
};

const handleClickOutside = (event) => {
  if (!profileMenuRef.value?.contains(event.target)) {
    closeProfileMenu();
  }
};

const logout = () => {
  closeLogoutModal();
  router.post(route('logout'));
};

onMounted(() => {
  document.addEventListener('click', handleClickOutside);
});

onBeforeUnmount(() => {
  document.removeEventListener('click', handleClickOutside);
});
</script>

<template>
  <div class="relative min-h-screen overflow-hidden bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100">
    <div class="pointer-events-none absolute inset-0 overflow-hidden">
      <div class="absolute -left-24 top-0 h-72 w-72 rounded-full bg-primary-500/10 blur-3xl dark:bg-primary-500/10"/>
      <div
        class="absolute right-0 top-32 h-72 w-72 rounded-full bg-secondary-500/10 blur-3xl dark:bg-secondary-500/10"/>
    </div>

    <ToastStack/>

    <div class="relative flex min-h-screen">
      <Transition
        enter-active-class="transition duration-200 ease-out"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition duration-150 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
      >
        <button
          v-if="displayNavigation && mobileSidebarOpen"
          type="button"
          class="fixed inset-0 z-30 bg-slate-950/40 backdrop-blur-[1px] lg:hidden"
          @click="mobileSidebarOpen = false"
        />
      </Transition>

      <aside
        v-if="displayNavigation"
        class="fixed inset-y-0 left-0 z-40 w-72 flex flex-col
         border-r border-slate-200 bg-white/90 text-slate-900
         shadow-sm backdrop-blur
         transition-all duration-200 ease-in-out
       dark:border-slate-800 dark:bg-slate-950/90 dark:text-slate-100
         overflow-y-auto"
        :class="[sidebarWidthClass, mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0']"
      >
        <div class="flex items-center justify-between border-b border-slate-200 px-4 py-4 dark:border-slate-800">
          <div class="flex items-center gap-3 overflow-hidden">
            <div
              class="flex h-10 w-10 shrink-0 items-center justify-center rounded-sm bg-linear-to-br from-primary-500 to-secondary-500 text-white">
              <span class="text-sm font-semibold">I</span>
            </div>
            <div class="min-w-0 transition-all duration-200 ease-in-out"
                 :class="collapsedSidebar ? 'max-w-0 opacity-0' : 'max-w-45 opacity-100'">
              <p class="text-sm font-semibold tracking-tight">{{ appName }}</p>
              <p class="text-xs text-slate-500 dark:text-slate-400">Minimal SaaS dashboard</p>
            </div>
          </div>

          <div class="flex items-center gap-1">
            <button
              type="button"
              class="rounded-sm p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-900 dark:hover:bg-slate-900 dark:hover:text-slate-100 lg:hidden"
              @click="mobileSidebarOpen = false"
            >
              <AppIcon name="close" class="h-4 w-4"/>
            </button>
            <button
              type="button"
              class="hidden rounded-sm p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-900 dark:hover:bg-slate-900 dark:hover:text-slate-100 lg:inline-flex"
              @click="collapsedSidebar = !collapsedSidebar"
            >
              <AppIcon :name="collapsedSidebar ? 'fa-chevron-right' : 'fa-chevron-left'" class="h-4 w-4"/>
            </button>
          </div>
        </div>

        <nav class="flex-1 space-y-2 px-3 py-4">
          <SidebarNavItem
            v-for="item in navItems"
            :key="item.href"
            :href="item.href"
            :icon="item.icon"
            :label="item.label"
            :active="isActive(item.href)"
            :collapsed="collapsedSidebar"
          />
        </nav>
      </aside>

      <div class="flex min-h-screen flex-1 flex-col transition-all duration-200 ease-in-out"
           :class="[displayNavigation ? (collapsedSidebar ? 'lg:ml-20' : 'lg:ml-72') : '']">
        <header
          class="sticky top-0 z-20 border-b border-slate-200 bg-slate-50/90 backdrop-blur dark:border-slate-800 dark:bg-slate-950/90">
          <div class="mx-auto flex w-full max-w-400 items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
            <div class="flex min-w-0 items-center gap-3">
              <button
                v-if="displayNavigation"
                type="button"
                class="inline-flex h-10 w-10 items-center justify-center rounded-sm border border-slate-200 bg-white/80 text-slate-600 transition hover:bg-slate-50 hover:text-slate-900 dark:border-slate-800 dark:bg-slate-900/70 dark:text-slate-300 dark:hover:bg-slate-900 dark:hover:text-white lg:hidden"
                @click="mobileSidebarOpen = true"
              >
                <AppIcon name="fa-bars" class="h-5 w-5"/>
              </button>

              <div
                v-else
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-sm bg-linear-to-br from-primary-500 to-secondary-500 text-white"
              >
                <span class="text-sm font-semibold">I</span>
              </div>

              <div class="min-w-0">
                <h1 class="truncate text-lg font-semibold tracking-tight text-slate-900 dark:text-slate-100 sm:text-xl">
                  {{ title }}
                </h1>
                <p v-if="description" class="mt-0.5 truncate text-sm text-slate-500 dark:text-slate-400">
                  {{ description }}
                </p>
                <div v-if="breadcrumbs.length" class="mt-1">
                  <Breadcrumbs :items="breadcrumbs"/>
                </div>
              </div>
            </div>

            <div class="flex items-center gap-2">
              <button
                type="button"
                class="inline-flex h-10 w-10 items-center justify-center rounded-sm border border-slate-200 bg-white/80 text-slate-500 transition hover:scale-[1.02] hover:bg-slate-50 hover:text-slate-900 dark:border-slate-800 dark:bg-slate-900/70 dark:text-slate-300 dark:hover:bg-slate-900 dark:hover:text-white"
                @click="toggleTheme"
              >
                <AppIcon :name="isDark ? 'fa-sun' : 'fa-moon'" class="h-4 w-4"/>
              </button>

              <button
                type="button"
                class="inline-flex h-10 w-10 items-center justify-center rounded-sm border border-slate-200 bg-white/80 text-slate-500 transition hover:scale-[1.02] hover:bg-slate-50 hover:text-slate-900 dark:border-slate-800 dark:bg-slate-900/70 dark:text-slate-300 dark:hover:bg-slate-900 dark:hover:text-white"
              >
                <AppIcon name="fa-bell" class="h-4 w-4"/>
              </button>

              <div
                v-if="isAuthenticated"
                ref="profileMenuRef"
                class="relative hidden sm:block"
              >
                <button
                  type="button"
                  class="flex items-center gap-3 rounded-sm border border-slate-200 bg-white/80 px-3 py-2 text-left text-sm transition hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900/70 dark:hover:bg-slate-900"
                  @click.stop="toggleProfileMenu"
                >
                  <div
                    class="flex h-8 w-8 items-center justify-center rounded-sm bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-300">
                    <AppIcon name="user" class="h-4 w-4"/>
                  </div>
                  <div class="leading-tight">
                    <p class="font-medium text-slate-900 dark:text-slate-100">
                      {{ userName }}
                    </p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">System owner</p>
                  </div>
                  <AppIcon
                    name="fa-chevron-down"
                    class="h-4 w-4 text-slate-400 transition-transform dark:text-slate-500"
                    :class="profileMenuOpen ? 'rotate-180' : ''"
                  />
                </button>

                <Transition
                  enter-active-class="transition duration-150 ease-out"
                  enter-from-class="translate-y-1 opacity-0"
                  enter-to-class="translate-y-0 opacity-100"
                  leave-active-class="transition duration-100 ease-in"
                  leave-from-class="translate-y-0 opacity-100"
                  leave-to-class="translate-y-1 opacity-0"
                >
                  <div
                    v-if="profileMenuOpen"
                    class="absolute right-0 top-full z-30 mt-2 w-56 rounded-sm border border-slate-200 bg-white/95 p-1 shadow-sm backdrop-blur dark:border-slate-800 dark:bg-slate-950/95"
                  >
                    <button
                      type="button"
                      class="flex w-full items-center gap-3 rounded-sm px-3 py-2 text-sm text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-900 dark:hover:text-white"
                      @click="router.get(route('settings'))"
                    >
                      <AppIcon name="fa-gear" class="h-4 w-4"/>
                      <span>Mi perfil</span>
                    </button>

                    <button
                      type="button"
                      class="flex w-full items-center gap-3 rounded-sm px-3 py-2 text-sm text-rose-600 transition hover:bg-rose-50 dark:text-rose-300 dark:hover:bg-rose-500/10"
                      @click="openLogoutModal"
                    >
                      <AppIcon name="fa-xmark" class="h-4 w-4"/>
                      <span>Cerrar sesion</span>
                    </button>
                  </div>
                </Transition>
              </div>
            </div>
          </div>
        </header>

        <main class="flex-1 px-4 py-5 sm:px-6 lg:px-8">
          <div class="mx-auto flex w-full max-w-400 flex-col gap-6">
            <slot/>
          </div>
        </main>
      </div>
    </div>

    <AppModal
      :show="logoutModalOpen"
      title="Cerrar sesion"
      @close="closeLogoutModal"
    >
      <template #subtitle>
        Esta accion cerrara tu sesion actual en el sistema.
      </template>

      <div class="space-y-3">
        <p class="text-sm text-slate-600 dark:text-slate-300">
          Se cerrara la sesion de <span class="font-medium text-slate-900 dark:text-slate-100">{{ userName }}</span> y
          volveras a la pantalla de acceso.
        </p>
        <p class="text-sm text-slate-500 dark:text-slate-400">
          Asegurate de haber guardado cualquier cambio pendiente antes de continuar.
        </p>
      </div>

      <template #footer>
        <AppButton variant="ghost" @click="closeLogoutModal">
          Cancelar
        </AppButton>
        <AppButton variant="primary" @click="logout">
          Confirmar salida
        </AppButton>
      </template>
    </AppModal>
  </div>
</template>
