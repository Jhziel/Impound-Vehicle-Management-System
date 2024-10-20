import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp, Head, Link } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import { library } from "@fortawesome/fontawesome-svg-core";
import VSelect from "vue-select";
import "vue-select/dist/vue-select.css";
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
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
    faUserNurse,
    faGavel,
    faCircleCheck,
    faCircleXmark,
    faFilePen,
    faCarSide,
    faCalendarDays,
    faArrowUp,
    faArrowDown,
    faCalendarWeek,
    faCalendarDay,
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
    faUsers,
    faUserNurse,
    faGavel,
    faCircleCheck,
    faCircleXmark,
    faFilePen,
    faCarSide,
    faCalendarDays,
    faArrowUp,
    faArrowDown,
    faCalendarWeek,
    faCalendarDay
);
// Set the components prop default to return our fresh components
VSelect.props.components.default = () => ({
    Deselect: {
        render: () => h("span", "❌"),
    },
    OpenIndicator: {
        render: () => h("span", "🔽"),
    },
});

const appName = import.meta.env.VITE_APP_NAME;

createInertiaApp({
    title: (title) => `${title} | ${appName}`,
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
            .component("v-select", VSelect)
            .use(plugin)
            .use(ZiggyVue)
            .use(VueSweetalert2)
            .mount(el);
    },

    progress: {
        color: "#4f46e5",
        showSpinner: true,
    },
});
