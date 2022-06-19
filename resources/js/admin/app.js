require('./custom');
import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import { ValidationObserver, ValidationProvider, extend, localize, configure } from 'vee-validate';
import en from 'vee-validate/dist/locale/en.json';
import * as rules from 'vee-validate/dist/rules';
import Loading from 'vue-loading-overlay';
import Notifications from 'vue-notification';
import DataTable from 'laravel-vue-datatable';
import axios from 'axios';
import routes from './routers';
import store from './stores';
import App from './layouts/App';
import url from './vee-validate/rules/types/url';
import password from './vee-validate/rules/types/password';

/**
 * Default configuration for validation roles
 *
 * @type {{dictionary: {en: {attributes: {toStation: string, journeyDate: string, className: string, fromStation: string}}}, classes: boolean, classNames: {valid: string[], dirty: string, untouched: string, touched: string, invalid: string[], pristine: string}, validity: boolean}}
 */
Object.keys(rules).forEach(rule => {
    extend(rule, rules[rule]);
});

const config = {
    classes: {
        touched: 'touched', // the control has been blurred
        untouched: 'untouched', // the control hasn't been blurred
        valid: ['border-success'], // model is valid
        invalid: ['border-danger'], // model is not valid
        pristine: 'pristine', // control has not been interacted with
        dirty: 'dirty', // control has been interacted with
    }
};

Vue.component('validation-observer', ValidationObserver);
Vue.component('validation-provider', ValidationProvider);
localize('en', en);
configure(config);

// Install components globally
Vue.component('ValidationObserver', ValidationObserver);
Vue.component('ValidationProvider', ValidationProvider);
Vue.use(Vuex);
Vue.use(Loading);
Vue.use(Notifications);
Vue.use(DataTable);

Vue.prototype.$loadingStart = function(container, canCancel = true, loader = "") {
    return this.$loading.show({
        container: container,
        canCancel: canCancel,
        loader: loader,
        color: "#0C9B8E"
    });
};

/** Axios configured globally **/
Vue.prototype.$axios = axios;

/** Layout defined **/

/** Route defined with store **/
Vue.use(VueRouter);

/** Application routes defined based on action **/
Vue.prototype.$store = store;

/** Route configured with vuex store and applicsaiton routes **/
let router = new VueRouter({
    routes: routes
});

router.beforeEach((to, from, next) => {
    if(to.matched.some(record => record.meta.requiresAuth)) {
        if (store.getters.isLoggedIn && ((to.path==='/') || (to.path==='/front-page')) ) {
            next('/company-infos');
            return;
        } else if (store.getters.isLoggedIn && ((to.path!=='/') || (to.path!=='/front-page')) ) {
            next();
            return;
        }

        next('/auth/login?redirect='+to.fullPath);
    } else {
        next();
    }
});

/** Run the application  **/
const app = new Vue({
    el: '#jsapp',
    router,
    render: h => h(App)
});
