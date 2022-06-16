require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';    
import { InertiaProgress } from '@inertiajs/progress';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .mixin({
                methods: {
                    route,
                    $can(permissionName) {
                        let roles = [];
                        for (const role of this.$page.props.auth.user.roles) {
                           roles.push(role.id)
                        }
                        // console.log(roles.includes(1));
                        if (!roles.includes(1))
                            return this.$page.props.permissions.indexOf(permissionName) !== -1;
                        else
                            return true;
                    },
                }
            })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
