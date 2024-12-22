import '../css/app.css';
import './bootstrap';

import { createInertiaApp, ResolvedComponent } from '@inertiajs/svelte';
import { hydrate, mount } from 'svelte';

createInertiaApp({
    resolve: (name: string) => {
        const pages = import.meta.glob<any>('./pages/**/*.svelte', { eager: true });
        return pages[`./pages/${name}.svelte`] as unknown as ResolvedComponent;
    },
    setup({ el, App, props }) {
        if (!el) throw new Error('Target element not found');
        if (el.dataset.serverRendered === 'true') {
            hydrate(App, { target: el, props });
        } else {
            mount(App, { target: el, props });
        }
    },
});