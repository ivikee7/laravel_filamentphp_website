import './bootstrap';
import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';

Alpine.plugin(intersect);

Alpine.store('theme', {
    current: localStorage.getItem('theme') || 'system',

    init() {
        this.apply();
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
            if (this.current === 'system') this.apply();
        });
    },

    set(mode) {
        this.current = mode;
        localStorage.setItem('theme', mode);
        this.apply();
    },

    apply() {
        const isDark =
            this.current === 'dark' ||
            (this.current === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);

        if (isDark) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }
});

window.Alpine = Alpine;
Alpine.start();
