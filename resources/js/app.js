import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp, Head, Link } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import { library } from "@fortawesome/fontawesome-svg-core";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import {
    faSun,
    faMoon,
    faHouse,
    faIdCard,
    faMapLocationDot,
    faFile,
    faBars,
    faUserLock,
    faUserGear,
    faPlus,
    faArrowLeft,
    faUsers,
} from "@fortawesome/free-solid-svg-icons";

library.add(
    faSun,
    faMoon,
    faHouse,
    faIdCard,
    faMapLocationDot,
    faFile,
    faBars,
    faUserLock,
    faUserGear,
    faPlus,
    faArrowLeft,
    faUsers
);

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .component("FontAwesomeIcon", FontAwesomeIcon)
            .component("Head", Head)
            .component("Link", Link)
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: "#4f46e5",
        showSpinner: true,
    },
});
