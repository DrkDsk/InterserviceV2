import {computed} from 'vue';
import {usePage} from '@inertiajs/vue3';
import {route} from 'ziggy-js';

const normalizePath = (href) => {
    if (!href) {
        return '/';
    }

    return new URL(href, 'http://localhost').pathname.replace(/\/+$/, '') || '/';
};

export function useRepairTabs(repairId, options = {}) {
    const page = usePage();

    const currentPath = computed(() => normalizePath(page.url.split('?')[0] || '/'));
    const logsCount = computed(() => options.logsCount?.value ?? options.logsCount ?? null);

    const isActive = (href) => normalizePath(href) === currentPath.value;

    return computed(() => {
        const detailsHref = route('repairs.edit', repairId);
        const logsHref = route('repairs.logs.index', repairId);
        const settingsHref = route('repairs.settings', repairId);

        return [
            {
                label: 'Detalles',
                href: detailsHref,
                active: isActive(detailsHref),
                icon: 'fa-screwdriver-wrench',
            },
            {
                label: 'Logs',
                href: logsHref,
                active: isActive(logsHref),
                icon: 'fa-file',
                badge: logsCount.value,
            },
            {
                label: 'Configuración',
                href: settingsHref,
                active: isActive(settingsHref),
                icon: 'fa-gear',
            },
        ];
    });
}
