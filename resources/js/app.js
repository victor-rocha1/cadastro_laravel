import { createApp } from 'vue';
import Home from './components/Home.vue';
import Pessoa from './components/cadastro/Pessoa.vue';
import Endereco from './components/cadastro/Endereco.vue';
import Lista from './components/admin/Lista.vue';
import Edit from './components/admin/Edit.vue';
import Restore from './components/admin/Restore.vue';
import Login from './components/auth/Login.vue';
import Register from './components/auth/Register.vue';

const path = window.location.pathname;

switch (path) {
    case '/':
        if (document.getElementById('home-app')) {
            createApp(Home).mount('#home-app');
        }
        break;

    case '/login':
        if (document.getElementById('login-app')) {
            createApp(Login).mount('#login-app');
        }
        break;

    case '/register':
        if (document.getElementById('register-app')) {
            createApp(Register).mount('#register-app');
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

    case '/admin/restore':
        if (document.getElementById('restore-app')) {
            createApp(Restore).mount('#restore-app');
        }
        break;

    default:
        if (/^\/(editar|admin\/\d+\/edit)$/.test(path)) {
            if (document.getElementById('edit-app')) {
                const idMatch = path.match(/\d+/); // pega o primeiro número da URL
                const id = idMatch ? idMatch[0] : null;

                if (id) {
                    createApp(Edit, { id: id }).mount('#edit-app');
                }
            }
        }
        break;
}