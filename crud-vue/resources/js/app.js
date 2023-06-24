require('./bootstrap');

import { createApp } from 'vue';
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
// import HelloVue from '../components/HelloVue.vue';
import Directory from '../components/Directory.vue';
// console.log(HelloVue);
createApp({
    components: 
    {
        // HelloVue,
        Directory,
    }
}).mount('#app');