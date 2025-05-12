import Pessoa from './components/Pessoa.vue';
import 'bootstrap';  // Importa o JavaScript do Bootstrap
import 'bootstrap/dist/css/bootstrap.min.css';  // Importa o CSS do Bootstrap
import { createApp } from 'vue';
import Home from './components/Home.vue';


const path = window.location.pathname;

if (path === '/pessoa') {
    createApp(Pessoa).mount('#pessoa-app');
} else {
    createApp(Home).mount('#home-app');
}