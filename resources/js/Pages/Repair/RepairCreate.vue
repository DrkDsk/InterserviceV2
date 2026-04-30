<script setup>
import {computed, nextTick, reactive, ref, watch} from 'vue'
import {useForm} from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import AppIcon from '@/Components/AppIcon.vue'
import AppCard from '@/Components/ui/AppCard.vue'
import AppButton from '@/Components/ui/AppButton.vue'
import AppInput from '@/Components/ui/AppInput.vue'
import AppTextarea from '@/Components/ui/AppTextarea.vue'
import AppSelect from '@/Components/ui/AppSelect.vue'

const props = defineProps({
  clients: {
    type: Array,
    default: () => [],
  },
  deviceCategories: {
    type: Array,
    default: () => [],
  },
  services: {
    type: Array,
    default: () => [],
  }
})

const breadcrumbs = [
  {label: 'Dashboard', href: 'dashboard'},
  {label: 'Reparaciones', href: 'repairs.index'},
  {label: 'Crear', href: null},
]

const steps = [
  {id: 1, label: 'Cliente', helper: 'Buscar o capturar'},
  {id: 2, label: 'Recepcion', helper: 'Notas internas'},
  {id: 3, label: 'Equipo', helper: 'Datos del dispositivo'},
  {id: 4, label: 'Confirmar', helper: 'Revision final'},
]

const currentStep = ref(1)
const clientSearch = ref('')
const showClientDropdown = ref(false)
const manualCustomerMode = ref(false)
const searchInputRef = ref(null)
const manualNameInputRef = ref(null)
const notesInputRef = ref(null)
const issueInputRef = ref(null)
const submitUrl = 'repairs.store'

const stepErrors = reactive({
  client_id: '',
  customer_name: '',
  customer_phone: '',
  issue: '',
})

const form = useForm({
  client_id: null,
  customer_name: '',
  customer_phone: '',
  notes: '',
  device_category_id: null,
  brand: '',
  model: '',
  serial_number: '',
  inventory_number: '',
  password: '',
  issue: '',
  observations: '',
  accessories: '',
  service_id: null,
})

const selectedClient = computed(() => (
  props.clients.find((client) => client.id === form.client_id) ?? null
))

const normalizedSearch = computed(() => clientSearch.value.trim().toLowerCase())

const filteredClients = computed(() => {
  if (!normalizedSearch.value) {
    return props.clients.slice(0, 6)
  }

  return props.clients
    .filter((client) => {
      const fullName = `${client.name ?? ''} ${client.last_name ?? ''}`.trim().toLowerCase()
      const phone = `${client.phone ?? ''}`.toLowerCase()

      return fullName.includes(normalizedSearch.value) || phone.includes(normalizedSearch.value)
    })
    .slice(0, 6)
})

const showManualCustomerFields = computed(() => (
  manualCustomerMode.value || (!!clientSearch.value.trim() && !form.client_id) || !!form.customer_name || !!form.customer_phone
))

const progressWidth = computed(() => `${((currentStep.value - 1) / (steps.length - 1)) * 100}%`)

const customerSummary = computed(() => {
  if (selectedClient.value) {
    return `${selectedClient.value.name ?? ''} ${selectedClient.value.last_name ?? ''}`.trim()
  }

  return form.customer_name || 'Cliente sin registrar'
})

const customerPhoneSummary = computed(() => (
  selectedClient.value?.phone || form.customer_phone || 'Sin telefono'
))

const selectedCategoryName = computed(() => (
  props.deviceCategories.find((category) => `${category.id}` === `${form.device_category_id}`)?.name || 'Sin categoria'
))

const selectedServiceName = computed(() => (
  props.services.find((service) => `${service.id}` === `${form.service_id}`)?.name || 'Sin nombre de servicio'
))

const focusField = (target) => {
  if (!target) {
    return
  }

  if (typeof target.focus === 'function') {
    target.focus()
    return
  }

  const element = target.$el?.querySelector?.('input, textarea, select')
  element?.focus?.()
}

watch(selectedClient, (client) => {
  if (!client) {
    return
  }

  clientSearch.value = `${client.name ?? ''} ${client.last_name ?? ''}`.trim()
  manualCustomerMode.value = false
})

watch(currentStep, async (step) => {
  await nextTick()

  if (step === 1) {
    if (showManualCustomerFields.value) {
      focusField(manualNameInputRef.value)
      return
    }

    focusField(searchInputRef.value)
    return
  }

  if (step === 2) {
    focusField(notesInputRef.value)
    return
  }

  if (step === 3) {
    focusField(issueInputRef.value)
  }
})

const setStepError = (field, message) => {
  stepErrors[field] = message
}

const clearStepError = (field) => {
  stepErrors[field] = ''
}

const handleSearchInput = (value) => {
  clientSearch.value = value
  showClientDropdown.value = true

  if (form.client_id) {
    form.client_id = null
  }

  clearStepError('client_id')
}

const selectClient = (client) => {
  form.client_id = client.id
  form.customer_name = ''
  form.customer_phone = ''
  clientSearch.value = `${client.name ?? ''} ${client.last_name ?? ''}`.trim()
  showClientDropdown.value = false
  manualCustomerMode.value = false
  clearStepError('client_id')
  clearStepError('customer_name')
  clearStepError('customer_phone')
}

const activateManualCustomer = async () => {
  form.client_id = null
  clientSearch.value = ''
  manualCustomerMode.value = true
  showClientDropdown.value = false
  await nextTick()
  focusField(manualNameInputRef.value)
}

const handleManualInput = (field, value) => {
  form.client_id = null
  form[field] = value
  manualCustomerMode.value = true
  clearStepError(field)
  clearStepError('client_id')
}

const hideDropdown = () => {
  window.setTimeout(() => {
    showClientDropdown.value = false
  }, 120)
}

const validateStep1 = () => {
  clearStepError('client_id')
  clearStepError('customer_name')
  clearStepError('customer_phone')

  if (form.client_id) {
    return true
  }

  let isValid = true

  if (!form.customer_name.trim()) {
    setStepError('customer_name', 'Ingresa el nombre del cliente.')
    isValid = false
  }

  if (!form.customer_phone.trim()) {
    setStepError('customer_phone', 'Ingresa un telefono de contacto.')
    isValid = false
  }

  if (!isValid) {
    setStepError('client_id', 'Selecciona un cliente existente o captura sus datos.')
  }

  return isValid
}

const validateStep3 = () => {
  clearStepError('issue')

  if (!form.issue.trim()) {
    setStepError('issue', 'Describe la falla o motivo de ingreso.')
    return false
  }

  return true
}

const nextStep = async () => {
  if (currentStep.value === 1 && !validateStep1()) {
    await nextTick()
    if (showManualCustomerFields.value) {
      focusField(manualNameInputRef.value)
      return
    }

    focusField(searchInputRef.value)
    return
  }

  if (currentStep.value === 3 && !validateStep3()) {
    await nextTick()
    focusField(issueInputRef.value)
    return
  }

  if (currentStep.value < steps.length) {
    currentStep.value += 1
  }
}

const previousStep = () => {
  if (currentStep.value > 1) {
    currentStep.value -= 1
  }
}

const submit = () => {
  const isStep1Valid = validateStep1()
  const isStep3Valid = validateStep3()

  if (!isStep1Valid) {
    currentStep.value = 1
    return
  }

  if (!isStep3Valid) {
    currentStep.value = 3
    return
  }

  form.post(route(submitUrl))
}
</script>

<template>
  <AppLayout
    title="Nueva reparación"
    description="Registro de recepción y equipo"
    :breadcrumbs="breadcrumbs"
  >
    <div class="mx-auto w-full">
      <AppCard class="overflow-hidden">
        <div class="border-b border-slate-200 px-6 py-5 dark:border-slate-800 sm:px-8">
          <div class="flex flex-col gap-5">
            <div class="flex items-start justify-between gap-4">
              <div>
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-primary-600 dark:text-primary-300">
                  Wizard de recepcion
                </p>
                <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">
                  Captura ordenada para una nueva reparacion
                </h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                  Avanza paso a paso y revisa todo antes de enviar la recepcion.
                </p>
              </div>

              <div
                class="hidden min-w-36 rounded-sm border border-slate-200 bg-slate-50 px-4 py-3 text-right dark:border-slate-800 dark:bg-slate-950/60 sm:block">
                <p class="text-xs uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Progreso</p>
                <p class="mt-1 text-lg font-semibold text-slate-900 dark:text-slate-100">{{ currentStep }}/4</p>
              </div>
            </div>

            <div class="relative">
              <div class="absolute left-0 right-0 top-5 h-px bg-slate-200 dark:bg-slate-800"/>
              <div class="absolute left-0 top-5 h-px bg-primary-500 transition-all duration-300"
                   :style="{ width: progressWidth }"/>

              <div class="relative grid gap-4 sm:grid-cols-4">
                <button
                  v-for="step in steps"
                  :key="step.id"
                  type="button"
                  class="text-left"
                  @click="step.id <= currentStep ? currentStep = step.id : null"
                >
                  <div class="flex items-center gap-3">
                    <div
                      class="flex h-10 w-10 items-center justify-center rounded-sm border text-sm font-semibold transition-all duration-200"
                      :class="step.id === currentStep
                        ? 'border-primary-500 bg-primary-500 text-white shadow-sm'
                        : step.id < currentStep
                          ? 'border-primary-500/30 bg-primary-500/10 text-primary-700 dark:text-primary-200'
                          : 'border-slate-200 bg-white text-slate-400 dark:border-slate-800 dark:bg-slate-950 dark:text-slate-500'"
                    >
                      {{ step.id }}
                    </div>

                    <div class="min-w-0">
                      <p
                        class="text-sm font-medium"
                        :class="step.id === currentStep ? 'text-slate-900 dark:text-slate-100' : 'text-slate-500 dark:text-slate-400'"
                      >
                        {{ step.label }}
                      </p>
                      <p class="text-xs text-slate-400 dark:text-slate-500">{{ step.helper }}</p>
                    </div>
                  </div>
                </button>
              </div>
            </div>
          </div>
        </div>

        <div class="px-6 py-6 sm:px-8">
          <Transition
            mode="out-in"
            enter-active-class="transition duration-250 ease-out"
            enter-from-class="translate-y-2 opacity-0"
            enter-to-class="translate-y-0 opacity-100"
            leave-active-class="transition duration-200 ease-in"
            leave-from-class="translate-y-0 opacity-100"
            leave-to-class="-translate-y-1 opacity-0"
          >
            <section :key="currentStep" class="space-y-6">
              <template v-if="currentStep === 1">
                <div class="space-y-2">
                  <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Cliente</h3>
                  <p class="text-sm text-slate-500 dark:text-slate-400">
                    Busca un cliente existente o captura los datos para continuar.
                  </p>
                </div>

                <div class="grid gap-6 lg:grid-cols-[1.3fr_0.7fr]">
                  <div class="space-y-4">
                    <div class="relative">
                      <label class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-200">
                        Buscar cliente
                      </label>
                      <div class="relative">
                        <span
                          class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                          <AppIcon name="fa-magnifying-glass" class="h-4 w-4"/>
                        </span>
                        <input
                          ref="searchInputRef"
                          :value="clientSearch"
                          type="text"
                          placeholder="Nombre, apellido o telefono"
                          class="block w-full rounded-sm border bg-white py-2 pl-10 pr-4 text-sm text-slate-900 transition duration-200 ease-in-out placeholder:text-slate-400 focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/15 dark:border-slate-800 dark:bg-slate-950 dark:text-slate-100 dark:placeholder:text-slate-500"
                          :class="stepErrors.client_id ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500/15' : 'border-slate-200'"
                          @input="handleSearchInput($event.target.value)"
                          @focus="showClientDropdown = true"
                          @blur="hideDropdown"
                        >
                      </div>
                      <p v-if="stepErrors.client_id" class="mt-1.5 text-xs text-rose-600 dark:text-rose-300">
                        {{ stepErrors.client_id }}
                      </p>

                      <div
                        v-if="showClientDropdown"
                        class="z-20 mt-2 w-full  overflow-hidden rounded-sm border border-slate-200 bg-white shadow-lg dark:border-slate-800 dark:bg-slate-950"
                      >
                        <button
                          v-for="client in filteredClients"
                          :key="client.id"
                          type="button"
                          class="flex w-full items-start justify-between gap-3 border-b border-slate-100 px-4 py-3 text-left transition hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-900"
                          @mousedown.prevent="selectClient(client)"
                        >
                          <div class="min-w-0">
                            <p class="truncate text-sm font-medium text-slate-900 dark:text-slate-100">
                              {{ `${client.name ?? ''} ${client.last_name ?? ''}`.trim() }}
                            </p>
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                              {{ client.phone || 'Sin telefono registrado' }}
                            </p>
                          </div>
                          <span class="text-xs text-slate-400 dark:text-slate-500">Seleccionar</span>
                        </button>

                        <div
                          v-if="!filteredClients.length"
                          class="px-4 py-4 text-sm text-slate-500 dark:text-slate-400"
                        >
                          No encontramos coincidencias con esa busqueda.
                        </div>
                      </div>
                    </div>

                    <div
                      v-if="selectedClient"
                      class="rounded-sm border border-primary-500/25 bg-primary-500/5 px-4 py-4 dark:bg-primary-500/10"
                    >
                      <div class="flex items-start justify-between gap-4">
                        <div>
                          <p
                            class="text-xs font-semibold uppercase tracking-[0.2em] text-primary-600 dark:text-primary-300">
                            Cliente seleccionado
                          </p>
                          <p class="mt-2 text-base font-semibold text-slate-900 dark:text-slate-100">
                            {{ `${selectedClient.name ?? ''} ${selectedClient.last_name ?? ''}`.trim() }}
                          </p>
                          <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                            {{ selectedClient.phone || 'Sin telefono registrado' }}
                          </p>
                        </div>

                        <button
                          type="button"
                          class="text-sm font-medium text-slate-500 transition hover:text-slate-900 dark:text-slate-400 dark:hover:text-slate-100"
                          @click="activateManualCustomer"
                        >
                          Cambiar
                        </button>
                      </div>
                    </div>

                    <div class="flex items-center gap-3">
                      <AppButton variant="ghost" @click="activateManualCustomer">
                        + Nuevo cliente
                      </AppButton>
                      <p class="text-xs text-slate-400 dark:text-slate-500">
                        Captura manual solo si no existe en la lista.
                      </p>
                    </div>
                  </div>

                  <div
                    class="rounded-sm border border-dashed border-slate-200 bg-slate-50/80 p-5 dark:border-slate-800 dark:bg-slate-950/50">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">
                      Contexto rapido
                    </p>
                    <div class="mt-4 space-y-3 text-sm text-slate-600 dark:text-slate-300">
                      <p>Usa la busqueda para evitar duplicados y conservar historial del cliente.</p>
                      <p>Si no existe, puedes capturarlo manualmente y continuar sin friccion.</p>
                    </div>
                  </div>
                </div>

                <div
                  v-if="showManualCustomerFields && !selectedClient"
                  class="grid gap-4 rounded-sm border border-slate-200 bg-slate-50/60 p-5 dark:border-slate-800 dark:bg-slate-950/40 md:grid-cols-2"
                >
                  <AppInput
                    ref="manualNameInputRef"
                    :model-value="form.customer_name"
                    label="Nombre del cliente"
                    placeholder="Ej. Maria Lopez"
                    :required="!form.client_id"
                    :error="stepErrors.customer_name"
                    @update:model-value="handleManualInput('customer_name', $event)"
                  />

                  <AppInput
                    :model-value="form.customer_phone"
                    label="Telefono de contacto"
                    placeholder="Ej. 55 1234 5678"
                    :required="!form.client_id"
                    :error="stepErrors.customer_phone"
                    @update:model-value="handleManualInput('customer_phone', $event)"
                  />
                </div>
              </template>

              <template v-else-if="currentStep === 2">
                <div class="space-y-2">
                  <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Recepcion</h3>
                  <p class="text-sm text-slate-500 dark:text-slate-400">
                    Agrega solo las notas necesarias para contextualizar el ingreso.
                  </p>
                </div>

                <AppTextarea
                  ref="notesInputRef"
                  v-model="form.notes"
                  label="Notas"
                  :rows="6"
                  hint="Opcional. Ejemplo: accesorios entregados, condiciones visibles o comentarios iniciales."
                />
              </template>

              <template v-else-if="currentStep === 3">
                <div class="space-y-2">
                  <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Equipo</h3>
                  <p class="text-sm text-slate-500 dark:text-slate-400">
                    Captura los datos del dispositivo y describe claramente la falla reportada.
                  </p>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                  <AppSelect
                    v-model="form.device_category_id"
                    label="Categoria"
                    hint="Opcional"
                  >
                    <option :value="null">Selecciona una categoria</option>
                    <option
                      v-for="category in deviceCategories"
                      :key="category.id"
                      :value="category.id"
                    >
                      {{ category.name }}
                    </option>
                  </AppSelect>

                  <AppSelect
                    v-model="form.service_id"
                    label="Tipo de Servicio"
                    hint="Requerido"
                  >
                    <option :value="null">Selecciona un tipo de servicio</option>
                    <option
                      v-for="services in services"
                      :key="services.id"
                      :value="services.id"
                    >
                      {{ services.name }}
                    </option>
                  </AppSelect>

                  <AppInput
                    v-model="form.brand"
                    label="Marca"
                    placeholder="Ej. Apple, Samsung, Lenovo"
                  />

                  <AppInput
                    v-model="form.model"
                    label="Modelo"
                    placeholder="Ej. iPhone 14, Galaxy A54"
                  />

                  <AppInput
                    v-model="form.serial_number"
                    label="Numero de serie"
                    placeholder="Serie del equipo"
                  />

                  <AppInput
                    v-model="form.inventory_number"
                    label="Numero de inventario"
                    placeholder="Folio o referencia interna"
                  />

                  <AppInput
                    v-model="form.password"
                    label="Contraseña"
                    placeholder="PIN, patron o clave temporal"
                  />
                </div>

                <div class="grid gap-4">
                  <AppTextarea
                    ref="issueInputRef"
                    v-model="form.issue"
                    label="Falla reportada"
                    :rows="4"
                    hint="Campo obligatorio"
                    required
                    :error="stepErrors.issue"
                  />

                  <AppTextarea
                    v-model="form.observations"
                    label="Observaciones"
                    :rows="4"
                    hint="Opcional. Estado fisico, golpes, humedad, etc."
                  />

                  <AppTextarea
                    v-model="form.accessories"
                    label="Accesorios"
                    :rows="4"
                    hint="Opcional. Cable, Adaptador, teclado, accesorios, etc."
                  />
                </div>
              </template>

              <template v-else>
                <div class="space-y-2">
                  <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Confirmacion</h3>
                  <p class="text-sm text-slate-500 dark:text-slate-400">
                    Revisa la informacion antes de crear la recepcion.
                  </p>
                </div>

                <div class="grid gap-4 lg:grid-cols-[1.1fr_0.9fr]">
                  <div class="space-y-4">
                    <div class="rounded-sm border border-slate-200 p-5 dark:border-slate-800">
                      <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">
                        Cliente
                      </p>
                      <p class="mt-3 text-lg font-semibold text-slate-900 dark:text-slate-100">
                        {{ customerSummary }}
                      </p>
                      <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                        {{ customerPhoneSummary }}
                      </p>
                    </div>

                    <div class="rounded-sm border border-slate-200 p-5 dark:border-slate-800">
                      <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">
                        Equipo
                      </p>
                      <dl class="mt-4 grid gap-3 text-sm sm:grid-cols-2">
                        <div>
                          <dt class="text-slate-400 dark:text-slate-500">Categoria</dt>
                          <dd class="mt-1 font-medium text-slate-900 dark:text-slate-100">{{
                              selectedCategoryName
                            }}
                          </dd>
                        </div>
                        <div>
                          <dt class="text-slate-400 dark:text-slate-500">Marca</dt>
                          <dd class="mt-1 font-medium text-slate-900 dark:text-slate-100">{{
                              form.brand || 'Sin dato'
                            }}
                          </dd>
                        </div>
                        <div>
                          <dt class="text-slate-400 dark:text-slate-500">Modelo</dt>
                          <dd class="mt-1 font-medium text-slate-900 dark:text-slate-100">{{
                              form.model || 'Sin dato'
                            }}
                          </dd>
                        </div>
                        <div>
                          <dt class="text-slate-400 dark:text-slate-500">Serie</dt>
                          <dd class="mt-1 font-medium text-slate-900 dark:text-slate-100">
                            {{ form.serial_number || 'Sin dato' }}
                          </dd>
                        </div>
                        <div>
                          <dt class="text-slate-400 dark:text-slate-500">Inventario</dt>
                          <dd class="mt-1 font-medium text-slate-900 dark:text-slate-100">
                            {{ form.inventory_number || 'Sin dato' }}
                          </dd>
                        </div>
                        <div>
                          <dt class="text-slate-400 dark:text-slate-500">Contrasena</dt>
                          <dd class="mt-1 font-medium text-slate-900 dark:text-slate-100">{{
                              form.password || 'Sin dato'
                            }}
                          </dd>
                        </div>
                      </dl>
                    </div>
                  </div>

                  <div class="space-y-4">

                    <div class="rounded-sm border border-slate-200 p-5 dark:border-slate-800">
                      <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">
                        Tipo de Servicio
                      </p>
                      <p class="mt-3 whitespace-pre-line text-sm text-slate-700 dark:text-slate-200">
                        {{ selectedServiceName || 'Sin descripcion' }}
                      </p>
                    </div>

                    <div class="rounded-sm border border-slate-200 p-5 dark:border-slate-800">
                      <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">
                        Accesorios
                      </p>
                      <p class="mt-3 whitespace-pre-line text-sm text-slate-700 dark:text-slate-200">
                        {{ form.accessories || 'Sin accesorios' }}
                      </p>
                    </div>

                    <div class="rounded-sm border border-slate-200 p-5 dark:border-slate-800">
                      <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">
                        Observaciones y notas
                      </p>
                      <p class="mt-3 whitespace-pre-line text-sm text-slate-700 dark:text-slate-200">
                        {{ form.observations || 'Sin observaciones adicionales.' }}
                      </p>
                      <div
                        class="mt-4 rounded-sm bg-slate-50 px-4 py-3 text-sm text-slate-500 dark:bg-slate-950/70 dark:text-slate-400">
                        {{ form.notes || 'Sin notas internas para la recepcion.' }}
                      </div>
                    </div>
                  </div>

                  <div class="space-y-4 w-full">
                    <div class="rounded-sm border border-slate-200 p-5 dark:border-slate-800">
                      <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">
                        Falla reportada
                      </p>
                      <p class="mt-3 whitespace-pre-line text-sm text-slate-700 dark:text-slate-200">
                        {{ form.issue || 'Sin descripcion' }}
                      </p>
                    </div>
                  </div>
                </div>
              </template>
            </section>
          </Transition>
        </div>

        <div
          class="flex flex-col gap-3 border-t border-slate-200 px-6 py-5 dark:border-slate-800 sm:flex-row sm:items-center sm:justify-end sm:px-8">

          <div class="flex items-center gap-3">
            <AppButton
              v-if="currentStep > 1"
              variant="outline"
              @click="previousStep"
            >
              Anterior
            </AppButton>

            <AppButton
              v-if="currentStep < steps.length"
              @click="nextStep"
            >
              Siguiente
            </AppButton>

            <AppButton
              v-else
              :disabled="form.processing"
              @click="submit"
            >
              {{ form.processing ? 'Creando...' : 'Crear recepcion' }}
            </AppButton>
          </div>
        </div>
      </AppCard>
    </div>
  </AppLayout>
</template>
