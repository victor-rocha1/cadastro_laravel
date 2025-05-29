<template>
    <div class="d-flex justify-content-center align-items-center min-vh-100 py-4">
        <div class="card p-4 shadow-lg border-0" style="width: 100%; max-width: 800px; border-radius: 12px;">
            <h1 class="text-center mb-4">Editar Cadastro</h1>

            <div v-if="feedbackMessage"
                :class="['alert', isError ? 'alert-danger' : 'alert-success', 'text-center', 'feedback-message']"
                role="alert">
                {{ feedbackMessage }}
            </div>

            <form @submit.prevent="atualizarPessoa" class="row g-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nome" class="form-label fw-bold">Nome:</label>
                        <input type="text" v-model="pessoa.nome" class="form-control" id="nome"
                            placeholder="Nome completo" required />
                    </div>

                    <div class="mb-3">
                        <label for="nome_social" class="form-label fw-bold">Nome Social (opcional):</label>
                        <input type="text" v-model="pessoa.nome_social" class="form-control" id="nome_social"
                            placeholder="Como prefere ser chamado(a)" />
                    </div>

                    <div class="mb-3">
                        <label for="cpf" class="form-label fw-bold">CPF:</label>
                        <input type="text" v-model="pessoa.cpf" @input="formatarCPF" maxlength="14" class="form-control"
                            id="cpf" placeholder="000.000.000-00" required />
                    </div>

                    <div class="mb-3">
                        <label for="nome_pai" class="form-label fw-bold">Nome do Pai (opcional):</label>
                        <input type="text" v-model="pessoa.nome_pai" class="form-control" id="nome_pai"
                            placeholder="Nome do pai" />
                    </div>

                    <div class="mb-3">
                        <label for="nome_mae" class="form-label fw-bold">Nome da Mãe (opcional):</label>
                        <input type="text" v-model="pessoa.nome_mae" class="form-control" id="nome_mae"
                            placeholder="Nome da mãe" />
                    </div>

                    <div class="mb-3">
                        <label for="telefone" class="form-label fw-bold">Telefone:</label>
                        <input type="tel" v-model="pessoa.telefone" @input="formatarTelefone" class="form-control"
                            id="telefone" placeholder="(00) 00000-0000" />
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">E-mail:</label>
                        <input type="email" v-model="pessoa.email" class="form-control" id="email"
                            placeholder="seuemail@exemplo.com" />
                    </div>
                </div>

                <div class="col-md-6" v-if="pessoa.endereco">
                    <div class="mb-3">
                        <label for="cep" class="form-label fw-bold">CEP:</label>
                        <input type="text" v-model="pessoa.endereco.cep" @input="formatarCEP" @blur="consultarCEP"
                            maxlength="9" class="form-control" id="cep" placeholder="00000-000" required />
                    </div>

                    <div class="mb-3">
                        <label for="logradouro" class="form-label fw-bold">Logradouro:</label>
                        <input type="text" v-model="pessoa.endereco.logradouro" class="form-control" id="logradouro"
                            placeholder="Rua, Avenida..." required />
                    </div>

                    <div class="mb-3">
                        <label for="numero" class="form-label fw-bold">Número:</label>
                        <input type="text" v-model="pessoa.endereco.numero" @input="somenteNumeros" maxlength="10"
                            class="form-control" id="numero" placeholder="Ex: 123, S/N" required />
                    </div>

                    <div class="mb-3">
                        <label for="complemento" class="form-label fw-bold">Complemento (opcional):</label>
                        <input type="text" v-model="pessoa.endereco.complemento" class="form-control" id="complemento"
                            placeholder="Apto, Bloco, Casa..." />
                    </div>

                    <div class="mb-3">
                        <label for="bairro" class="form-label fw-bold">Bairro:</label>
                        <input type="text" v-model="pessoa.endereco.bairro" class="form-control" id="bairro" required />
                    </div>

                    <div class="mb-3">
                        <label for="estado" class="form-label fw-bold">Estado:</label>
                        <select v-model="pessoa.endereco.estado" class="form-select" id="estado" required>
                            <option disabled value="">Selecione o estado</option>
                            <option v-for="uf in estados" :key="uf" :value="uf">{{ uf }}</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="cidade" class="form-label fw-bold">Cidade:</label>
                        <input type="text" v-model="pessoa.endereco.cidade" class="form-control" id="cidade" required />
                    </div>
                </div>

                <div class="col-12">
                    <div class="mt-2 d-flex flex-column flex-sm-row gap-2">
                        <a href="/lista" class="btn btn-secondary w-100 flex-sm-fill">Voltar para Lista
                        </a>
                        <button type="submit" class="btn btn-success w-100 flex-sm-fill">
                            Salvar Alterações
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    props: {
        id: {
            type: Number,
            required: true,
        },
    },
    data() {
        return {
            pessoa: {
                nome: "",
                nome_social: "",
                cpf: "",
                nome_pai: "",
                nome_mae: "",
                telefone: "",
                email: "",
                endereco: {},
            },
            estados: [
                "AC", "AL", "AP", "AM", "BA", "CE", "DF", "ES", "GO", "MA", "MT", "MS", "MG", "PA", "PB", "PR", "PE", "PI", "RJ", "RN", "RS", "RO", "RR", "SC", "SP", "SE", "TO",
            ],
        };
    },
    created() {
        this.carregarDados();
    },
    methods: {
        carregarDados() {
            axios
                .get(`/api/admin/${this.id}`)
                .then((res) => {
                    this.pessoa = res.data;
                    if (!this.pessoa.endereco) this.pessoa.endereco = {};
                })
                .catch((err) => {
                    console.error("Erro ao carregar dados:", err);
                    alert("Não foi possível carregar os dados.");
                });
        },
        atualizarPessoa() {
            axios
                .put(`/admin/${this.id}`, this.pessoa)
                .then(() => {
                    alert("Dados atualizados com sucesso!");
                    window.location.href = "/lista";
                })
                .catch((err) => {
                    console.error("Erro na atualização:", err);
                    const errorMessage = err.response && err.response.data && err.response.data.message
                        ? err.response.data.message
                        : "Erro ao salvar dados.";
                    alert(errorMessage);
                });
        },
        excluirPessoa() {
            if (confirm("Tem certeza que deseja excluir este cadastro? Ele será arquivado, mas não removido permanentemente.")) {
                axios
                    .delete(`/api/admin/${this.id}`)
                    .then((res) => {
                        alert(res.data.message || "Cadastro excluído com sucesso!");
                        window.location.href = "/lista";
                    })
                    .catch((err) => {
                        console.error("Erro ao excluir cadastro:", err);
                        const errorMessage = err.response && err.response.data && err.response.data.message
                            ? err.response.data.message
                            : "Erro ao excluir cadastro.";
                        alert(errorMessage);
                    });
            }
        },
        formatarCPF(event) {
            let v = event.target.value.replace(/\D/g, "");
            v = v.replace(/(\d{3})(\d)/, "$1.$2");
            v = v.replace(/(\d{3})(\d)/, "$1.$2");
            v = v.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
            this.pessoa.cpf = v;
        },
        consultarCEP() {
            if (!this.pessoa.endereco.cep) return;
            const cepLimpo = this.pessoa.endereco.cep.replace(/\D/g, "");
            if (cepLimpo.length !== 8) {
                alert("CEP inválido");
                return;
            }
            axios
                .get(`https://viacep.com.br/ws/${cepLimpo}/json/`)
                .then((res) => {
                    if (res.data.erro) {
                        alert("CEP não encontrado");
                        return;
                    }
                    this.pessoa.endereco.logradouro = res.data.logradouro;
                    this.pessoa.endereco.bairro = res.data.bairro;
                    this.pessoa.endereco.cidade = res.data.localidade;
                    this.pessoa.endereco.estado = res.data.uf;
                })
                .catch(() => {
                    alert("Erro ao consultar CEP.");
                });
        },
        somenteNumeros(event) {
            event.target.value = event.target.value.replace(/\D/g, "");
            this.pessoa.endereco.numero = event.target.value;
        },
    },
};
</script>