import { createApp } from 'vue';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';
import '@fortawesome/fontawesome-free/css/all.min.css';
import Home from './components/Home.vue';
import Pessoa from './components/cadastro/Pessoa.vue';
import Endereco from './components/cadastro/Endereco.vue';
import Lista from './components/admin/Lista.vue';


const path = window.location.pathname;

switch (path) {
    case '/':
        if (document.getElementById('home-app')) {
            createApp(Home).mount('#home-app');
        }
        break;

    case '/pessoa':
        if (document.getElementById('pessoa-app')) {
            createApp(Pessoa).mount('#pessoa-app');
        }
        break;

    case '/endereco':
        if (document.getElementById('endereco-app')) {
            createApp(Endereco).mount('#endereco-app');
        }
        break;

    case '/lista':
        if (document.getElementById('lista-app')) {
            createApp(Lista).mount('#lista-app');
        }
        break;

    default:
        console.error('Nenhum app correspondente encontrado para a rota:', path);
        break;
}