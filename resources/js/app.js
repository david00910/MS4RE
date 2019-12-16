/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import axios from 'axios'


require('./bootstrap');

window.Vue = require('vue');

// Local components (own)
import Pagination from './components/misc/Pagination';
import User from './components/self_service/User';
import MyProperties from "./components/self_service/MyProperties";
import CreateProperties from "./components/properties/CreateProperties";
import ShowProperty from "./components/properties/ShowProperty";
import Footer from "./components/misc/Footer";
import AdminDashboard from "./components/admin_dashboard/AdminDashboard";

// Third party, installed components
import vueNumeralFilterInstaller from 'vue-numeral-filter';
import VueSlider from 'vue-slider-component';
import 'vue-slider-component/theme/default.css';
import VueDawa from '@ancaio/vue-dawa/sfc';
import * as VueGoogleMaps from 'vue2-google-maps';
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css';
import VueAnalytics from 'vue-analytics';

// use default options
// Numeral filter for outputs
Vue.use(vueNumeralFilterInstaller);
Vue.use(VueGoogleMaps, {
    load: {
        key: 'AIzaSyDiuzgWa9UMFgyTb7rn-cZVnPkGjVpnHVY',
        libraries: 'places',
    },
});

Vue.use(VueAnalytics, {
    id: 'UA-XXX-X',
    checkDuplicatedScript: true
});



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Return authenticated user, so Vue modules can access it.
Vue.prototype.$user = window.Laravel.user;

// Return Laravel csrf token and save it in a Vue global variable.
Vue.prototype.$csrf = window.Laravel.csrfToken;


// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('properties', require('./components/properties/Properties.vue').default);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.prototype.$dawa = require('dawa-autocomplete2');
Vue.component('pagination', Pagination);
Vue.component('user', User);
Vue.component('admin-dashboard', AdminDashboard);
Vue.component('myproperties', MyProperties);
Vue.component('createproperties', CreateProperties);
Vue.component('showproperty', ShowProperty);
Vue.component('v-footer', Footer);
Vue.component('vue-slider', VueSlider);
Vue.component('vue-dawa', VueDawa);
Vue.component('vue-dropzone', vue2Dropzone);



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    components: {
        VueDawa,
    }

});
