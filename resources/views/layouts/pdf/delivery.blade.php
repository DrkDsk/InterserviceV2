<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrega de reparación</title>
    <style>
        {!! Vite::content('resources/css/pdf.css') !!}
    </style>
</head>
<body>

<main class="pdf-shell">
    <section class="pdf-report">
        <header class="pdf-header">
            <div class="pdf-header-content">
                <div class="pdf-brand">
                    <div class="pdf-brand-mark">
                        {{ $companyInitial }}
                    </div>

                    <div>
                        <p class="pdf-eyebrow">Interservice</p>
                        <h1 class="pdf-title">Comprobante de entrega</h1>
                    </div>
                </div>

                <p class="pdf-header-copy">
                    Documento de control administrativo con trazabilidad de recepción, diagnóstico y entrega final
                    del equipo.
                </p>
            </div>

            <aside class="pdf-folio-card">
                <p class="pdf-label">Folio de servicio</p>
                <p class="pdf-folio">{{ $reception['folio'] ?? 'Sin folio' }}</p>
                <p class="pdf-muted">Generado el {{ $generatedAt }}</p>
            </aside>
        </header>

        <section class="pdf-metrics" aria-label="Resumen del servicio">
            <article class="pdf-metric-card">
                <p class="pdf-label">Cliente</p>
                <p class="pdf-metric-value">{{ $reception['customer_name'] ?? 'Cliente no registrado' }}</p>
                <p class="pdf-muted">{{ $reception['customer_phone'] ?? 'Sin teléfono' }}</p>
            </article>

            <article class="pdf-metric-card">
                <p class="pdf-label">Estado reparación</p>
                <div class="pdf-badge {{ $repairBadgeTone }}">
                    <span class="pdf-badge-dot"></span>
                    {{ $repairLabel }}
                </div>
                <p class="pdf-muted">Técnico: {{ $repair['technician_name'] ?? 'No asignado' }}</p>
            </article>

            <article class="pdf-metric-card">
                <p class="pdf-label">Estado recepción</p>
                <div class="pdf-badge {{ $receptionBadgeTone }}">
                    <span class="pdf-badge-dot"></span>
                    {{ $statusLabel }}
                </div>
                <p class="pdf-muted">Ingreso: {{ $receptionDate }}</p>
            </article>

            <article class="pdf-metric-card">
                <p class="pdf-label">Días en resguardo</p>
                <p class="pdf-days">{{ $days_stored ?? 0 }}</p>
                <p class="pdf-muted">Entrega: {{ $deliveredDate }}</p>
            </article>
        </section>

        <div class="pdf-divider"></div>

        <section class="pdf-content-stack">
            <div class="pdf-top-panels">
                <section class="pdf-panel pdf-contact-panel">
                    <div class="pdf-section-header is-compact">
                        <div>
                            <p class="pdf-eyebrow">Contacto</p>
                            <h2 class="pdf-section-title is-small">Información de la sucursal</h2>
                        </div>

                        <div class="pdf-badge is-success">Activo</div>
                    </div>

                    <div class="pdf-contact-list">
                        <div class="pdf-info-row">
                            <span>Teléfono</span>
                            <strong>{{ $setup_company->phone ?? 'No disponible' }}</strong>
                        </div>

                        <div class="pdf-info-row">
                            <span>WhatsApp</span>
                            <strong>{{ $setup_company->WhatsApp ?? 'No disponible' }}</strong>
                        </div>

                        <div class="pdf-info-row">
                            <span>Correo</span>
                            <strong>{{ $setup_company->email ?? 'No disponible' }}</strong>
                        </div>

                        <div class="pdf-info-row">
                            <span>Facebook</span>
                            <strong>{{ $setup_company->facebook ?? 'No disponible' }}</strong>
                        </div>

                        <div class="pdf-location-box">
                            <p>Ubicación</p>
                            <strong>
                                {{ $setup_company->location ?? 'Ubicación no disponible' }}
                                @if(!blank($setup_company->city))
                                    , {{ $setup_company->city }}
                                @endif
                            </strong>
                        </div>
                    </div>
                </section>

                <section class="pdf-panel pdf-admin-panel">
                    <p class="pdf-eyebrow">Cliente y recepción</p>
                    <h2 class="pdf-section-title">Datos administrativos</h2>

                    <div class="pdf-info-stack">
                        <div class="pdf-info-box is-white">
                            <p class="pdf-field-label">Teléfono</p>
                            <p class="pdf-field-value">{{ $reception['customer_phone'] ?? 'No registrado' }}</p>
                        </div>

                        <div class="pdf-info-box is-white">
                            <p class="pdf-field-label">Notas de ingreso</p>
                            <p class="pdf-note-copy">{{ $reception['notes'] ?? 'Sin notas registradas.' }}</p>
                        </div>
                    </div>
                </section>
            </div>

            <section class="pdf-panel pdf-technical-panel">
                <div class="pdf-section-header">
                    <div>
                        <p class="pdf-eyebrow">Resumen técnico</p>
                        <h2 class="pdf-section-title">Detalle del equipo</h2>
                    </div>

                    <div class="pdf-id-chip">
                        <p>ID reparación</p>
                        <strong>#{{ $repair['id'] ?? 'N/A' }}</strong>
                    </div>
                </div>

                <div class="pdf-info-grid">
                    <div class="pdf-info-box">
                        <p class="pdf-field-label">Equipo</p>
                        <p class="pdf-field-value">{{ $repair['device_name'] ?? 'No disponible' }}</p>
                    </div>

                    <div class="pdf-info-box">
                        <p class="pdf-field-label">Costo</p>
                        <p class="pdf-field-value">{{ $repairCost }}</p>
                    </div>

                    <div class="pdf-info-box">
                        <p class="pdf-field-label">Fecha de reparación</p>
                        <p class="pdf-field-value">{{ $repairedDate }}</p>
                    </div>

                    <div class="pdf-info-box">
                        <p class="pdf-field-label">Recepción ID</p>
                        <p class="pdf-field-value">#{{ $repair['reception_id'] ?? 'N/A' }}</p>
                    </div>
                </div>
            </section>

            <section class="pdf-panel pdf-repair-panel">
                <div class="pdf-section-header">
                    <div>
                        <p class="pdf-eyebrow">Resumen técnico</p>
                        <h2 class="pdf-section-title">Reparación</h2>
                    </div>
                </div>

                <div class="pdf-notes-stack">
                    <article class="pdf-note-card">
                        <div class="pdf-note-heading">
                            <span class="pdf-status-dot is-warning"></span>
                            <p>Falla reportada</p>
                        </div>
                        <p class="pdf-note-copy">{{ $repair['issue'] ?? 'Sin descripción de falla.' }}</p>
                    </article>

                    <article class="pdf-note-card">
                        <div class="pdf-note-heading">
                            <span class="pdf-status-dot is-primary"></span>
                            <p>Observaciones</p>
                        </div>
                        <p class="pdf-note-copy">{{ $repair['observations'] ?? 'Sin observaciones registradas.' }}</p>
                    </article>

                    <article class="pdf-note-card">
                        <div class="pdf-note-heading">
                            <span class="pdf-status-dot is-success"></span>
                            <p>Solución aplicada</p>
                        </div>
                        <p class="pdf-note-copy">{{ $repair['solution'] ?? 'Pendiente de registrar solución técnica.' }}</p>
                    </article>
                </div>
            </section>
        </section>

        <footer class="pdf-footer">
            <div>
                <p class="pdf-eyebrow">Cierre administrativo</p>
                <p class="pdf-footer-copy">
                    Este comprobante respalda la entrega del equipo y resume la información registrada dentro
                    del flujo operativo de Interservice.
                </p>
            </div>
        </footer>
    </section>
</main>
</body>
</html>
