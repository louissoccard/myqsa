require('./bootstrap');
window.progressBars = require('./progressBars');

let progressBars = [];

import {createApp, h} from 'vue';
import {createInertiaApp} from '@inertiajs/inertia-vue3';
import AppLayout from "@/Layouts/AppLayout";
import NProgress from "nprogress";
import { Inertia } from "@inertiajs/inertia";

const appName = window.document.getElementsByTagName('title')[0]?.innerText;


createInertiaApp({
    title: (title) => `${title} | ${appName}`,
    resolve: (name) => {
        const page = require(`./Pages/${name}`);

        if (name.startsWith('App/')) {
            page.default.layout = page.default.layout || AppLayout;
        }

        return page.default;
    },
    setup({el, app, props, plugin}) {
        return createApp({render: () => h(app, props)})
            .use(plugin)
            .mixin({methods: {route}})
            .mount(el);
    },
});

// Page loading progress bar
NProgress.configure({
    template: '<div class="bar bg-navy dark:bg-white w-full fixed top-0 left-0 h-0.5 z-50 shadow-md" role="bar"><div class="peg w-4 h-4 bg-navy rounded-full"></div></div>',
});

let timeout = null;

Inertia.on('start', () => {
    timeout = setTimeout(() => NProgress.start(), 250);
});

Inertia.on('progress', (event) => {
    if (NProgress.isStarted() && event.detail.progress.percentage) {
        NProgress.set((event.detail.progress.percentage / 100) * 0.9);
    }
});

Inertia.on('finish', (event) => {
    clearTimeout(timeout);
    if (!NProgress.isStarted()) {
        return;
    } else if (event.detail.visit.completed) {
        NProgress.done();
    } else if (event.detail.visit.interrupted) {
        NProgress.set(0);
    } else if (event.detail.visit.cancelled) {
        NProgress.done();
        NProgress.remove();
    }
});
