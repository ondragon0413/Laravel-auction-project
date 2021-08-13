require('./bootstrap');
require('./ckeditor');

require('alpinejs');

import Vue from 'vue'
window.Vue = require('vue');
window.io = require("socket.io-client");

Vue.component('bid-countdown-timer', require('./components/BidCountdownTimer.vue').default);
Vue.component('new-bid', require('./components/NewBid.vue').default);

const app = new Vue({
    el: '#app'
});
