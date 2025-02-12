import './bootstrap';
import { createApp } from 'vue';
import CryptoPriceForm from './components/CryptoPriceForm.vue';

const app = createApp({});
app.component('crypto-price-form', CryptoPriceForm);
app.mount('#vue-crypto-price-form');