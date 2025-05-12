<template>
    <div class="d-flex justify-content-center align-items-center min-vh-100 mt-5">
        <div class="card p-4 shadow-lg border-0" style="width: 100%; max-width: 500px; border-radius: 12px;">
            <h1 class="d-flex justify-content-center">Cadatro</h1>
            <form @submit.prevent="submitForm">
                <div class="mb-3">
                    <label for="nome" class="form-label fw-bold">Nome:</label>
                    <input type="text" class="form-control" v-model="form.nome" placeholder="Nome"
                        :class="{ 'is-invalid': errors.nome }" required />
                    <div v-if="errors.nome" class="invalid-feedback">{{ errors.nome }}</div>
                </div>

                <div class="mb-3">
                    <label for="nome_social" class="form-label fw-bold">Nome Social (opcional):</label>
                    <input type="text" class="form-control" v-model="form.nome_social" placeholder="Nome Social" />
                </div>

                <div class="mb-3">
                    <label for="cpf" class="form-label fw-bold">CPF:</label>
                    <input type="text" class="form-control" v-model="form.cpf" placeholder="000.000.000-00" required
                        @input="formatarCPF" maxlength="14" />
                    <div v-if="errors.cpf" class="invalid-feedback">{{ errors.cpf }}</div>
                </div>

                <div class="mb-3">
                    <label for="nome_pai" class="form-label fw-bold">Nome do Pai:</label>
                    <input type="text" class="form-control" v-model="form.nome_pai" placeholder="Nome do Pai" />
                </div>

                <div class="mb-3">
                    <label for="nome_mae" class="form-label fw-bold">Nome da Mãe:</label>
                    <input type="text" class="form-control" v-model="form.nome_mae" placeholder="Nome da Mãe" />
                </div>

                <div class="mb-3">
                    <label for="telefone" class="form-label fw-bold">Telefone:</label>
                    <input type="tel" class="form-control" v-model="form.telefone" placeholder="(31) 99999-9999" />
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">E-mail:</label>
                    <input type="email" class="form-control" v-model="form.email" placeholder="pessoa@gmail.com" />
                </div>

                <!-- Botões Voltar e Próximo -->
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" @click="voltar">Voltar</button>
                    <button type="submit" class="btn btn-success" @click="irParaCadastro">Próximo</button>
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
            // Formatação do CPF para o formato 000.000.000-00
            this.form.cpf = this.form.cpf.replace(/\D/g, '');
            if (this.form.cpf.length > 3 && this.form.cpf.length <= 6) {
                this.form.cpf = this.form.cpf.replace(/(\d{3})(\d{1,3})/, '$1.$2');
            } else if (this.form.cpf.length > 6 && this.form.cpf.length <= 9) {
                this.form.cpf = this.form.cpf.replace(/(\d{3})(\d{3})(\d{1,3})/, '$1.$2.$3');
            } else if (this.form.cpf.length > 9) {
                this.form.cpf = this.form.cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
            }
        },
        submitForm() {
            // Enviando os dados do formulário
            console.log('Formulário enviado:', this.form);

            // Aqui você chama o backend para salvar os dados e, se tudo estiver certo, redireciona
            axios.post('/api/cadastro', this.form)
                .then(response => {
                    // Sucesso, redireciona para a página de Endereço (via Laravel)
                    window.location.href = '/endereco'; // Redireciona para a página de endereço
                })
                .catch(error => {
                    // Tratar erros de validação
                    this.errors = error.response.data.errors;
                });
        },
        endereco() {
            window.location.href = '/pessoa'; // Redireciona pra view de cadastro
        },

        voltar() {
            this.$router.push({ name: 'previous-step' }); // Voltar para a página anterior
        }
    }
};
</script>

<style scoped>
.card {
    border-radius: 12px;
}
</style>