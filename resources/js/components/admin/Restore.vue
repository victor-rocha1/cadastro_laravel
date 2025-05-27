<template>
    <div class="container my-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mb-0">Pessoas Excluídas</h1>
            <a href="/lista" class="btn btn-secondary btn-sm d-flex align-items-center">
                <i class="fas fa-arrow-left me-2"></i> Voltar
            </a>
        </div>

        <div v-if="successMessage" class="alert alert-success text-center">
            {{ successMessage }}
        </div>

        <div v-if="pessoas.length === 0" class="text-center text-danger">
            <p>Nenhuma pessoa excluída.</p>
        </div>

        <div v-else class="row justify-content-center mt-4">
            <div
                v-for="pessoa in pessoas"
                :key="pessoa.id"
                class="col-12 col-md-6 col-lg-4 mb-4"
            >
                <div class="card h-100 shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-user-slash text-danger me-2"></i> {{ pessoa.nome }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Email:</strong> {{ pessoa.email }}</p>
                        <p><strong>CPF:</strong> {{ pessoa.cpf }}</p>
                        <p v-if="pessoa.deleted_at">
                            <strong>Excluído em:</strong> {{ formatarData(pessoa.deleted_at) }}
                        </p>
                    </div>
                    <div class="card-footer d-flex gap-2">
                        <button
                            type="button"
                            @click="confirmarRestauracao(pessoa.id)"
                            class="btn btn-primary btn-sm d-flex align-items-center"
                        >
                            <i class="fas fa-undo me-1"></i> Restaurar
                        </button>

                        <button
                            type="button"
                            @click="confirmarExclusaoPermanente(pessoa.id)"
                            class="btn btn-danger btn-sm d-flex align-items-center"
                        >
                            <i class="fas fa-trash me-1"></i> Excluir
                        </button>
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
            pessoas: [],
            successMessage: '',
        };
    },
    mounted() {
        this.carregarPessoasExcluidas();
        // A mensagem de sucesso ainda pode vir da window, se houver
        this.successMessage = window.successMessage || '';
    },
    methods: {
        carregarPessoasExcluidas() {
            axios.get('/api/pessoas/trashed')
                .then(response => {
                    this.pessoas = response.data;
                })
                .catch(error => {
                    console.error("Erro ao carregar pessoas excluídas:", error);
                    this.pessoas = [];
                    this.successMessage = 'Erro ao carregar dados de pessoas excluídas. Tente novamente.';
                });
        },
        formatarData(dataString) {
            if (!dataString) return '';
            const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
            return new Date(dataString).toLocaleDateString('pt-BR', options);
        },
        confirmarRestauracao(id) {
            if (confirm('Tem certeza que deseja restaurar esta pessoa?')) {
                this.restaurarPessoa(id);
            }
        },
        restaurarPessoa(id) {
            axios.post(`/api/admin/${id}/restore`) // Nova rota API para restaurar
                .then(response => {
                    this.successMessage = response.data.message || 'Pessoa restaurada com sucesso!';
                    // Remove a pessoa da lista localmente
                    this.pessoas = this.pessoas.filter(pessoa => pessoa.id !== id);
                })
                .catch(error => {
                    console.error("Erro ao restaurar pessoa:", error);
                    this.successMessage = 'Erro ao restaurar pessoa. Tente novamente.';
                });
        },
        confirmarExclusaoPermanente(id) {
            if (confirm('Tem certeza que deseja EXCLUIR PERMANENTEMENTE esta pessoa? Esta ação não pode ser desfeita.')) {
                this.excluirPermanentemente(id);
            }
        },
        excluirPermanentemente(id) {
            axios.delete(`/api/admin/${id}/force-delete`) // Nova rota API para exclusão permanente
                .then(response => {
                    this.successMessage = response.data.message || 'Pessoa excluída permanentemente!';
                    // Remove a pessoa da lista localmente
                    this.pessoas = this.pessoas.filter(pessoa => pessoa.id !== id);
                })
                .catch(error => {
                    console.error("Erro ao excluir permanentemente:", error);
                    this.successMessage = 'Erro ao excluir permanentemente. Tente novamente.';
                });
        },
    },
};
</script>

<style scoped>
/* Adicione estilos específicos para este componente se necessário */
.card-header {
    background-color: #f8d7da; /* Light red for deleted items */
    border-bottom: 1px solid #dc3545;
}
.card-title {
    color: #dc3545; /* Red text for deleted items */
}
</style>