/**
 * Carrega a biblioteca Axios para facilitar as requisições HTTP
 * para a API Laravel. Essa configuração já adiciona o token CSRF
 * no cabeçalho automaticamente.
 */
window.axios = require('axios');

// Indica que as requisições são AJAX
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// (Opcional) Define a URL base para as requisições HTTP (útil se usar prefixos como /api)
window.axios.defaults.baseURL = '/';