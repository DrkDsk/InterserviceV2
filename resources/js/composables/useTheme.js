import { computed, ref, watch } from 'vue';

export const THEME_STORAGE_KEY = 'interservice-theme';

export function getPreferredTheme() {
    if (typeof window === 'undefined') {
        return 'light';
    }

    const stored = window.localStorage.getItem(THEME_STORAGE_KEY);

    if (stored === 'dark' || stored === 'light') {
        return stored;
    }

    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
}

export function applyTheme(theme) {
    if (typeof document === 'undefined') {
        return;
    }

    const root = document.documentElement;
    root.classList.toggle('dark', theme === 'dark');
    root.style.colorScheme = theme;
}

export function initTheme() {
    const theme = getPreferredTheme();
    applyTheme(theme);
    return theme;
}

export function useTheme() {
    const theme = ref(getPreferredTheme());

    const isDark = computed(() => theme.value === 'dark');

    const setTheme = (nextTheme) => {
        theme.value = nextTheme;

        if (typeof window !== 'undefined') {
            window.localStorage.setItem(THEME_STORAGE_KEY, nextTheme);
        }

        applyTheme(nextTheme);
    };

    const toggleTheme = () => {
        setTheme(isDark.value ? 'light' : 'dark');
    };

    watch(theme, (nextTheme) => {
        applyTheme(nextTheme);
    });

    return {
        theme,
        isDark,
        setTheme,
        toggleTheme,
    };
}
