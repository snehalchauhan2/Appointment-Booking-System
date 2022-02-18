
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.IziToast = require('izitoast');
window.Vue = require('vue');
window.moment = require('moment');

/**
 * Wrappers
 * Here are the code made do simplify the proccess with Toast, Ajax, etc
 */

// Toast Wrapper - Adapts the IziToast to use inside the AxiosWrapper
window.Toast = require('./wrappers/toastWrapper');

// Loader Wrapper - Adapts the Loader to use inside the AxiosWrapper
window.Loader = require('./wrappers/loaderWrapper');

// Creates an Axios wrapper that receives the toast library to internal use
let AxiosWrapper = require('./wrappers/axiosWrapper');
window.AxiosWrapper = new AxiosWrapper(Toast, Loader);

// External components
import FullCalendar from 'vue-full-calendar';
import VeeValidate from 'vee-validate';

// Custom components
import BookCalendar from './components/BookCalendarComponent.vue';
import BookBusinessHours from './components/BookBusinessHoursComponent.vue';
import BookUserPhones from './components/BookUserPhonesComponent.vue';
import DatePicker from './components/DatePickerComponent.vue';

Vue.use(FullCalendar);
Vue.use(VeeValidate);

const app = new Vue({
    el: '#app',
    components: { 
        BookCalendar,
        BookBusinessHours,
        BookUserPhones,
        DatePicker
    }
});
