require("./bootstrap");

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";

const appName =
    window.document.getElementsByTagName("title")[0]?.innerText || "Laravel";

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
                        permissionName = permissionName.includes("|")
                            ? permissionName.split("|")
                            : permissionName;
                        // console.log("user permission", this.$page.props.permissions);

                        let roles = [];
                        for (const role of this.$page.props.auth.user.roles) {
                            roles.push(role.name);
                        }

                        if (!roles.includes("Super Admin")) {
                            if (permissionName instanceof Array) {
                                let arr = [];
                                for (let permission of permissionName) {
                                    let result =
                                        this.$page.props.permissions.indexOf(
                                            permission
                                        ) !== -1;
                                    arr.push(result);
                                }
                                return arr.includes(true) ? true : false;
                            }
                            return (
                                this.$page.props.permissions.indexOf(
                                    permissionName
                                ) !== -1
                            );
                        } else return true;
                    },
                },
            })
            .mount(el);
    },
});

InertiaProgress.init({ color: "#4B5563" });
