import { createInertiaApp } from '@inertiajs/svelte'
import createServer from '@inertiajs/svelte/server'
import { render } from 'svelte/server'
import type { ResolvedComponent } from '@inertiajs/svelte'

createServer(page =>
  createInertiaApp({
    page,
    resolve: (name: string): ResolvedComponent => {
      const pages = import.meta.glob<{ default: ResolvedComponent }>('./Pages/**/*.svelte', { eager: true })
      return pages[`./Pages/${name}.svelte`].default
    },
    setup({ App, props }) {
      return render(App, { props })
    },
  }),
)