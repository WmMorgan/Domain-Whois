import vueRouter from 'vue-router';
import Vue from 'vue';

Vue.use(vueRouter);

import Whois from "./components/Whois";

const routes = [
    {
        path: "/whois",
        component: Whois
    }
];

export default new vueRouter( {
    mode: "history",
    routes
});
