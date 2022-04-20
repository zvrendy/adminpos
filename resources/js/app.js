require('./bootstrap');

window.Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})

// // Import modules...
// import { createApp, h } from 'vue';
// import { createInertiaApp } from '@inertiajs/inertia-vue3';
// import { InertiaProgress } from '@inertiajs/progress';

// // Import component...
// import Multiselect from '@suadelabs/vue3-multiselect';

// const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

// createInertiaApp({
//     title: (title) => `${title} - ${appName}`,
//     resolve: (name) => require(`./Pages/${name}.vue`),
//     setup({ el, app, props, plugin }) {
//         return createApp({ render: () => h(app, {
//             initialPage: JSON.parse(el.dataset.page),
//             resolveComponent: (name) => require(`./Pages/${name}`).default,
//         }), })
//             .use(plugin)
//             .mixin({ methods: { route } })
//             .component('multiselect', Multiselect)
//             .mount(el);
//     },
// });

// Import modules...
import { createApp, h } from 'vue';
import { App as InertiaApp, plugin as InertiaPlugin, Head, Link, } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';

// Import components...
import Multiselect from '@suadelabs/vue3-multiselect'

const el = document.getElementById('app');

createApp({
    render: () =>
        h(InertiaApp, {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: (name) =>
            // require(`./Pages/${name}`).default,
            import(`@/Pages/${name}`).then((module) => module.default),
        }),
    })
    .mixin({ methods: { route } })
    .use(InertiaPlugin)
    .component('multiselect', Multiselect)
    .component('InertiaHead', Head)
    .component('InertiaLink', Link)
    .mount(el);


InertiaProgress.init({ color: '#4B5563' });
