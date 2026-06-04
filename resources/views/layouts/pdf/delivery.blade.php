<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrega de reparación</title>
    <style>
        {!! Vite::content('resources/css/app.css') !!}
    </style>
</head>
<body class="font-sans text-neutral-900">

<main class="pdf-shell px-6 py-6">
    <section class="pdf-card overflow-hidden rounded-[28px] border border-neutral-200 bg-white shadow-soft">
        <div class="border-b border-neutral-200 bg-gradient-to-br from-primary-50 via-white to-white px-8 py-8">
            <div class="flex items-start justify-between gap-6">
                <div class="max-w-[68%]">
                    <div class="mb-5 flex items-center gap-4">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary-500 text-lg font-semibold text-white shadow-lg shadow-primary-500/20">
                            {{ $companyInitial }}
                        </div>

                        <div>
                            <p class="text-[11px] font-semibold uppercase tracking-[0.28em] text-primary-500">
                                Interservice
                            </p>
                            <h1 class="mt-1 text-3xl font-semibold tracking-tight text-neutral-900">
                                Comprobante de entrega
                            </h1>
                        </div>
                    </div>

                    <p class="max-w-2xl text-sm leading-6 text-neutral-500">
                        Documento de control administrativo con trazabilidad de recepción, diagnóstico y entrega final
                        del equipo.
                    </p>
                </div>

                <div class="min-w-57.5 rounded-3xl border border-primary-100 bg-white/90 p-5 text-right shadow-sm">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.24em] text-neutral-400">
                        Folio de servicio
                    </p>
                    <p class="mt-2 text-2xl font-semibold tracking-tight text-neutral-900">
                        {{ $reception['folio'] ?? 'Sin folio' }}
                    </p>
                    <p class="mt-3 text-xs text-neutral-500">
                        Generado el {{ $generatedAt }}
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-4 gap-4 px-8 py-6">
            <article class="pdf-card metric-accent rounded-3xl border border-neutral-200 bg-neutral-50 px-5 py-4">
                <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-neutral-400">Cliente</p>
                <p class="mt-3 text-base font-semibold text-neutral-900">{{ $reception['customer_name'] ?? 'Cliente no registrado' }}</p>
                <p class="mt-1 text-xs text-neutral-500">{{ $reception['customer_phone'] ?? 'Sin teléfono' }}</p>
            </article>

            <article class="pdf-card metric-accent rounded-3xl border border-neutral-200 bg-neutral-50 px-5 py-4">
                <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-neutral-400">Estado reparación</p>
                <div
                    class="mt-3 inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-xs font-semibold {{ $repairBadge['wrap'] }}">
                    <span class="h-2 w-2 rounded-full {{ $repairBadge['dot'] }}"></span>
                    {{ $repairLabel }}
                </div>
                <p class="mt-2 text-xs text-neutral-500">Técnico: {{ $repair['technician_name'] ?? 'No asignado' }}</p>
            </article>

            <article class="pdf-card metric-accent rounded-3xl border border-neutral-200 bg-neutral-50 px-5 py-4">
                <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-neutral-400">Estado recepción</p>
                <div
                    class="mt-3 inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-xs font-semibold {{ $receptionBadge['wrap'] }}">
                    <span class="h-2 w-2 rounded-full {{ $receptionBadge['dot'] }}"></span>
                    {{ $statusLabel }}
                </div>
                <p class="mt-2 text-xs text-neutral-500">
                    Ingreso: {{ $receptionDate }}</p>
            </article>

            <article class="pdf-card metric-accent rounded-3xl border border-neutral-200 bg-neutral-50 px-5 py-4">
                <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-neutral-400">Días en resguardo</p>
                <p class="mt-3 text-3xl font-semibold tracking-tight text-neutral-900">{{ $days_stored ?? 0 }}</p>
                <p class="mt-1 text-xs text-neutral-500">
                    Entrega: {{ $deliveredDate }}</p>
            </article>
        </div>

        <div class="px-8">
            <div class="pdf-divider"></div>
        </div>

        <div class="grid grid-cols-12 gap-6 px-8 py-8">
            <section class="pdf-card col-span-7 rounded-[26px] border border-neutral-200 bg-white p-6 shadow-sm">
                <div class="mb-6 flex items-center justify-between gap-4">
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-[0.24em] text-primary-500">Resumen
                            técnico</p>
                        <h2 class="mt-2 text-xl font-semibold tracking-tight text-neutral-900">Detalle del equipo y
                            reparación</h2>
                    </div>

                    <div class="rounded-2xl bg-primary-50 px-3 py-2 text-right">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-primary-500">ID
                            reparación</p>
                        <p class="mt-1 text-sm font-semibold text-neutral-900">#{{ $repair['id'] ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="rounded-2xl border border-neutral-200 bg-neutral-50 p-4">
                        <p class="text-xs font-medium text-neutral-400">Equipo</p>
                        <p class="mt-2 text-sm font-semibold text-neutral-900">{{ $repair['device_name'] ?? 'No disponible' }}</p>
                    </div>

                    <div class="rounded-2xl border border-neutral-200 bg-neutral-50 p-4">
                        <p class="text-xs font-medium text-neutral-400">Costo</p>
                        <p class="mt-2 text-sm font-semibold text-neutral-900">{{ $repairCost }}</p>
                    </div>

                    <div class="rounded-2xl border border-neutral-200 bg-neutral-50 p-4">
                        <p class="text-xs font-medium text-neutral-400">Fecha de reparación</p>
                        <p class="mt-2 text-sm font-semibold text-neutral-900">{{ $repairedDate }}</p>
                    </div>

                    <div class="rounded-2xl border border-neutral-200 bg-neutral-50 p-4">
                        <p class="text-xs font-medium text-neutral-400">Recepción ID</p>
                        <p class="mt-2 text-sm font-semibold text-neutral-900">
                            #{{ $repair['reception_id'] ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="mt-6 space-y-4">
                    <article class="rounded-3xl border border-neutral-200 bg-white p-5">
                        <div class="mb-3 flex items-center gap-2">
                            <span class="h-2.5 w-2.5 rounded-full bg-warning-500"></span>
                            <p class="text-sm font-semibold text-neutral-900">Falla reportada</p>
                        </div>
                        <p class="text-sm leading-7 text-neutral-600">{{ $repair['issue'] ?? 'Sin descripción de falla.' }}</p>
                    </article>

                    <article class="rounded-3xl border border-neutral-200 bg-white p-5">
                        <div class="mb-3 flex items-center gap-2">
                            <span class="h-2.5 w-2.5 rounded-full bg-primary-500"></span>
                            <p class="text-sm font-semibold text-neutral-900">Observaciones</p>
                        </div>
                        <p class="text-sm leading-7 text-neutral-600">{{ $repair['observations'] ?? 'Sin observaciones registradas.' }}</p>
                    </article>

                    <article class="rounded-3xl border border-neutral-200 bg-white p-5">
                        <div class="mb-3 flex items-center gap-2">
                            <span class="h-2.5 w-2.5 rounded-full bg-success-500"></span>
                            <p class="text-sm font-semibold text-neutral-900">Solución aplicada</p>
                        </div>
                        <p class="text-sm leading-7 text-neutral-600">{{ $repair['solution'] ?? 'Pendiente de registrar solución técnica.' }}</p>
                    </article>
                </div>
            </section>

            <aside class="pdf-card col-span-5 space-y-6">
                <section class="rounded-[26px] border border-neutral-200 bg-neutral-50 p-6 shadow-sm">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.24em] text-primary-500">Cliente y
                        recepción</p>
                    <h2 class="mt-2 text-xl font-semibold tracking-tight text-neutral-900">Datos administrativos</h2>

                    <div class="mt-6 space-y-4">

                        <div class="rounded-2xl border border-neutral-200 bg-white p-4">
                            <p class="text-xs font-medium text-neutral-400">Teléfono</p>
                            <p class="mt-1 text-sm font-semibold text-neutral-900">{{ $reception['customer_phone'] ?? 'No registrado' }}</p>
                        </div>

                        <div class="rounded-2xl border border-neutral-200 bg-white p-4">
                            <p class="text-xs font-medium text-neutral-400">Notas de ingreso</p>
                            <p class="mt-1 text-sm leading-6 text-neutral-600">{{ $reception['notes'] ?? 'Sin notas registradas.' }}</p>
                        </div>
                    </div>
                </section>

                <section class="rounded-[26px] border border-neutral-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-[11px] font-semibold uppercase tracking-[0.24em] text-primary-500">
                                Contacto</p>
                            <h2 class="mt-2 text-lg font-semibold tracking-tight text-neutral-900">Información de la
                                sucursal</h2>
                        </div>

                        <div
                            class="rounded-2xl bg-success-50 px-3 py-2 text-xs font-semibold text-success-500 ring-1 ring-inset ring-success-500/20">
                            Activo
                        </div>
                    </div>

                    <div class="mt-6 space-y-3 text-sm text-neutral-600">
                        <div
                            class="flex items-start justify-between gap-4 rounded-2xl border border-neutral-200 bg-neutral-50 px-4 py-3">
                            <span class="font-medium text-neutral-500">Teléfono</span>
                            <span
                                class="text-right font-semibold text-neutral-900">{{ $setup_company->phone ?? 'No disponible' }}</span>
                        </div>

                        <div
                            class="flex items-start justify-between gap-4 rounded-2xl border border-neutral-200 bg-neutral-50 px-4 py-3">
                            <span class="font-medium text-neutral-500">WhatsApp</span>
                            <span
                                class="text-right font-semibold text-neutral-900">{{ $setup_company->WhatsApp ?? 'No disponible' }}</span>
                        </div>

                        <div
                            class="flex items-start justify-between gap-4 rounded-2xl border border-neutral-200 bg-neutral-50 px-4 py-3">
                            <span class="font-medium text-neutral-500">Correo</span>
                            <span
                                class="text-right font-semibold text-neutral-900">{{ $setup_company->email ?? 'No disponible' }}</span>
                        </div>

                        <div
                            class="flex items-start justify-between gap-4 rounded-2xl border border-neutral-200 bg-neutral-50 px-4 py-3">
                            <span class="font-medium text-neutral-500">Facebook</span>
                            <span
                                class="text-right font-semibold text-neutral-900">{{ $setup_company->facebook ?? 'No disponible' }}</span>
                        </div>

                        <div class="rounded-2xl border border-neutral-200 bg-neutral-50 px-4 py-3">
                            <p class="font-medium text-neutral-500">Ubicación</p>
                            <p class="mt-1 font-semibold text-neutral-900">
                                {{ $setup_company->location ?? 'Ubicación no disponible' }}
                                @if(!blank($setup_company->city))
                                    , {{ $setup_company->city }}
                                @endif
                            </p>
                        </div>
                    </div>
                </section>
            </aside>
        </div>

        <div class="px-8 pb-8">
            <div class="rounded-[26px] border border-neutral-200 bg-neutral-950 px-6 py-5 text-white">
                <div class="flex items-end justify-between gap-6">
                    <div class="max-w-2xl">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.24em] text-primary-500">Cierre
                            administrativo</p>
                        <p class="mt-2 text-sm leading-6 text-neutral-300">
                            Este comprobante respalda la entrega del equipo y resume la información registrada dentro
                            del flujo operativo de Interservice.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
</body>
</html>
