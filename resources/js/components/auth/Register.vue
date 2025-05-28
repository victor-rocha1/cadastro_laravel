<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-4">
                        <h3 class="text-center mb-4">Criar Conta</h3>
                        <div v-if="successMessage" class="alert alert-success text-center">
                            {{ successMessage }} <a href="/login">Clique aqui para fazer login</a>.
                        </div>
                        <form @submit.prevent="handleRegister" v-if="!successMessage">
                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Nome</label>
                                <input type="text" v-model="form.name" id="name" class="form-control"
                                    :class="{ 'is-invalid': errors.name }" placeholder="Digite seu nome" required>
                                <div v-if="errors.name" class="invalid-feedback">{{ errors.name[0] }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">E-mail</label>
                                <input type="email" v-model="form.email" id="email" class="form-control"
                                    :class="{ 'is-invalid': errors.email }" placeholder="Digite seu e-mail" required>
                                <div v-if="errors.email" class="invalid-feedback">{{ errors.email[0] }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-bold">Senha</label>
                                <input type="password" v-model="form.password" id="password" class="form-control"
                                    :class="{ 'is-invalid': errors.password }" placeholder="Digite sua senha" required>
                                <div v-if="errors.password" class="invalid-feedback">{{ errors.password[0] }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label fw-bold">Confirmar Senha</label>
                                <input type="password" v-model="form.password_confirmation" id="password_confirmation"
                                    class="form-control" placeholder="Confirme sua senha" required>
                            </div>
                            <div v-if="generalError" class="alert alert-danger text-center mt-3">
                                {{ generalError }}
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-dark btn-lg" :disabled="loading">
                                    <span v-if="loading" class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    Criar Conta
                                </button>
                            </div>
                        </form>
                        <div class="text-center mt-3">
                            <p class="mb-0">Já tem uma conta? <a href="/login">Faça login</a></p>
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
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
            },
            errors: {},
            generalError: '',
            successMessage: '',
            loading: false,
        };
    },
    methods: {
        async handleRegister() {
            this.loading = true;
            this.errors = {};
            this.generalError = '';
            this.successMessage = '';
            try {
                await axios.get('/sanctum/csrf-cookie'); // Para CSRF
                const response = await axios.post('/api/register', this.form); // Chama a rota API
                this.successMessage = response.data.message;
                this.form = { name: '', email: '', password: '', password_confirmation: '' }; // Limpa o formulário
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    this.errors = error.response.data.errors;
                } else if (error.response && error.response.data && error.response.data.message) {
                    this.generalError = error.response.data.message;
                }
                else {
                    this.generalError = 'Ocorreu um erro durante o registro. Tente novamente.';
                    console.error('Erro no registro:', error);
                }
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>