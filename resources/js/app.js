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
                        console.log(this.$page.props.permissions.includes("Roles List"));
                        // console.log(this.$page.props.permissions.match(permissionName));
                        // array.some(e =>console.log( myRegex.test(e)))
                        
                        let roles = [];
                        for (const role of this.$page.props.auth.user.roles) {
                           roles.push(role.name)
                        }
                        // console.log(roles.includes(1));
                        if (!roles.includes("Super Admin"))
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
