
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require("materialize-css");

window.Vue = require('vue');
window.moment = require("moment");

// Filters
import date from './filters/date'
import money from './filters/money'
import amountInLetters from './filters/amount-in-letters'
import asset from './filters/asset'

Vue.use(date)
Vue.use(money)
Vue.use(amountInLetters)
Vue.use(asset)

import swal from "sweetalert";

window.showLoading = function () {
    $("#prepage-loader").fadeIn('fast');
};

window.pickDateI18n = {
    nextMonth: 'Mes siguiente',
    previousMonth: 'Mes anterior',
    // Months and weekdays
    months: [ 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre' ],
    monthsShort: [ 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic' ],
    weekdays: [ 'Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado' ],
    weekdaysShort: [ 'Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab' ],
    // Materialize modified
    weekdaysAbbrev: [ 'D', 'L', 'M', 'M', 'J', 'V', 'S' ],
    // Today and clear
    today: 'Hoy',
    clear: 'Limpiar',
    done: 'Aceptar'
}

// Format Number
Number.prototype.formatMoney = function (c, d, t) {
    var n = this,
        c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
        j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

// Input masked
import MaskedInput from 'vue-text-mask'
Vue.component('masked-input', MaskedInput);

// Cards
Vue.component("card-main", require("./components/card/CardMain.vue"));
Vue.component("card-content", require("./components/card/CardContent.vue"));
Vue.component("card-title", require("./components/card/CardTitle.vue"));

// Login
Vue.component('login-form', require('./components/login/FormLogin.vue'));
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});
