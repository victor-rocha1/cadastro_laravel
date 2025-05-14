<template>
    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="card p-4 shadow-lg border-0" style="width: 100%; max-width: 500px; border-radius: 12px;">
            <h1 class="d-flex justify-content-center mb-4">Cadastro</h1>

            <form @submit.prevent="submitForm">
                <!-- Nome -->
                <div class="mb-3">
                    <label for="nome" class="form-label fw-bold">Nome:</label>
                    <input id="nome" type="text" class="form-control" v-model="form.nome" placeholder="Nome"
                        :class="{ 'is-invalid': errors.nome }" required />
                    <div v-if="errors.nome" class="invalid-feedback">{{ errors.nome }}</div>
                </div>

                <!-- Nome Social -->
                <div class="mb-3">
                    <label for="nome_social" class="form-label fw-bold">Nome Social (opcional):</label>
                    <input id="nome_social" type="text" class="form-control" v-model="form.nome_social"
                        placeholder="Nome Social" />
                </div>

                <!-- CPF -->
                <div class="mb-3">
                    <label for="cpf" class="form-label fw-bold">CPF:</label>
                    <input id="cpf" type="text" class="form-control" v-model="form.cpf" placeholder="000.000.000-00"
                        @input="formatarCPF" maxlength="14" :class="{ 'is-invalid': errors.cpf }" required />
                    <div v-if="errors.cpf" class="invalid-feedback">{{ errors.cpf }}</div>
                </div>

                <!-- Nome do Pai -->
                <div class="mb-3">
                    <label for="nome_pai" class="form-label fw-bold">Nome do Pai:</label>
                    <input id="nome_pai" type="text" class="form-control" v-model="form.nome_pai"
                        placeholder="Nome do Pai" />
                </div>

                <!-- Nome da Mãe -->
                <div class="mb-3">
                    <label for="nome_mae" class="form-label fw-bold">Nome da Mãe:</label>
                    <input id="nome_mae" type="text" class="form-control" v-model="form.nome_mae"
                        placeholder="Nome da Mãe" />
                </div>

                <!-- Telefone -->
                <div class="mb-3">
                    <label for="telefone" class="form-label fw-bold">Telefone:</label>
                    <input id="telefone" type="tel" class="form-control" v-model="form.telefone"
                        placeholder="(31) 99999-9999" />
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">E-mail:</label>
                    <input id="email" type="email" class="form-control" v-model="form.email"
                        placeholder="pessoa@gmail.com" />
                </div>

                <!-- Botões -->
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" @click="voltar">Voltar</button>
                    <button type="submit" class="btn btn-success">Próximo</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            form: {
                nome: '',
                nome_social: '',
                cpf: '',
                nome_pai: '',
                nome_mae: '',
                telefone: '',
                email: ''
            },
            errors: {}
        };
    },
    methods: {
        formatarCPF() {
            let cpf = this.form.cpf.replace(/\D/g, '');
            cpf = cpf.slice(0, 11); // limita a 11 dígitos numéricos
            cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
            cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
            cpf = cpf.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            this.form.cpf = cpf;
        },
        submitForm() {
            axios.post('/pessoa', this.form)
                .then(response => {
                    // Redireciona com pessoa_id recebido do backend
                    window.location.href = response.data.redirect;
                })
                .catch(error => {
                    if (error.response && error.response.data.errors) {
                        this.errors = error.response.data.errors;
                    } else {
                        console.error('Erro ao enviar dados:', error);
                    }
                });
        },
        voltar() {
            history.back();
        }
    }
};
</script>

<style scoped>
.card {
    border-radius: 12px;
}
</style>
