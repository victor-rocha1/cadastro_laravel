<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-4">
                        <h1 class="text-center mb-4">Login</h1>
                        <form @submit.prevent="handleLogin">
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">E-mail</label>
                                <input type="email" v-model="form.email" id="email" class="form-control"
                                    placeholder="Digite seu e-mail" required>
                                <div v-if="errors.email" class="invalid-feedback d-block">{{ errors.email[0] }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-bold">Senha</label>
                                <input type="password" v-model="form.password" id="password" class="form-control"
                                    placeholder="Digite sua senha" required>
                                <div v-if="errors.password" class="invalid-feedback d-block">{{ errors.password[0] }}
                                </div>
                            </div>

                            <div v-if="generalError" class="alert alert-danger text-center mt-3">
                                {{ generalError }}
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-dark btn-lg" :disabled="loading">
                                    <span v-if="loading" class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    Entrar
                                </button>
                            </div>
                        </form>
                        <div class="text-center mt-3">
                            <p class="mb-0">Ainda não tem uma conta? <a href="/register">Cadastre-se</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            form: {
                email: '',
                password: '',
            },
            errors: {},
            generalError: '',
            loading: false,
        };
    },
    methods: {
        async handleLogin() {
            this.loading = true;
            this.errors = {};
            this.generalError = '';
            try {
                await axios.get('/sanctum/csrf-cookie'); // Necessário para Sanctum estabelecer a sessão CSRF
                const response = await axios.post('/api/login', this.form); // Chama a rota API

                if (response.data.user) {
                    localStorage.setItem('user', JSON.stringify(response.data.user));
                    localStorage.setItem('is_admin', response.data.user.is_admin);
                }
                window.location.href = '/'; 
            } catch (error) {
                if (error.response && error.response.status === 422) { 
                    this.errors = error.response.data.errors;
                    if (this.errors.email && this.errors.email[0] === 'As credenciais fornecidas estão incorretas.') {
                        this.generalError = 'E-mail ou senha incorretos. Tente novamente.';
                        delete this.errors.email; 
                    }
                } else if (error.response && error.response.data && error.response.data.message) {
                    this.generalError = error.response.data.message;
                }
                else {
                    this.generalError = 'Ocorreu um erro ao tentar fazer login. Tente novamente.';
                    console.error('Erro no login:', error);
                }
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>
