<template>
    <form @submit.prevent="atualizarPessoa" class="row">
        <!-- Coluna Pessoa -->
        <div class="col-md-6">
            <div class="mb-3">
                <label for="nome">Nome:</label>
                <input type="text" v-model="pessoa.nome" class="form-control" id="nome" placeholder="Nome" required />
            </div>

            <div class="mb-3">
                <label for="nome_social">Nome Social (opcional):</label>
                <input type="text" v-model="pessoa.nome_social" class="form-control" id="nome_social"
                    placeholder="Nome Social" />
            </div>

            <div class="mb-3">
                <label for="cpf">CPF:</label>
                <input type="text" v-model="pessoa.cpf" @input="formatarCPF" maxlength="14" class="form-control"
                    id="cpf" placeholder="000.000.000-00" required />
            </div>

            <div class="mb-3">
                <label for="nome_pai">Nome do Pai:</label>
                <input type="text" v-model="pessoa.nome_pai" class="form-control" id="nome_pai"
                    placeholder="Nome do Pai" />
            </div>

            <div class="mb-3">
                <label for="nome_mae">Nome da Mãe:</label>
                <input type="text" v-model="pessoa.nome_mae" class="form-control" id="nome_mae"
                    placeholder="Nome da Mãe" />
            </div>

            <div class="mb-3">
                <label for="telefone">Telefone:</label>
                <input type="tel" v-model="pessoa.telefone" class="form-control" id="telefone"
                    placeholder="(31) 99999-9999" />
            </div>

            <div class="mb-3">
                <label for="email">E-mail:</label>
                <input type="email" v-model="pessoa.email" class="form-control" id="email"
                    placeholder="pessoa@gmail.com" />
            </div>
        </div>

        <!-- Coluna Endereço -->
        <div class="col-md-6" v-if="pessoa.endereco">
            <div class="mb-3">
                <label for="cep">CEP:</label>
                <input type="text" v-model="pessoa.endereco.cep" @blur="consultarCEP" maxlength="10"
                    class="form-control" id="cep" placeholder="00000-000" required />
            </div>

            <div class="mb-3">
                <label for="logradouro">Logradouro:</label>
                <input type="text" v-model="pessoa.endereco.logradouro" class="form-control" id="logradouro" required />
            </div>

            <div class="mb-3">
                <label for="numero">Número:</label>
                <input type="text" v-model="pessoa.endereco.numero" @input="somenteNumeros" maxlength="4"
                    class="form-control" id="numero" placeholder="00" required />
            </div>

            <div class="mb-3">
                <label for="complemento">Complemento:</label>
                <input type="text" v-model="pessoa.endereco.complemento" class="form-control" id="complemento" />
            </div>

            <div class="mb-3">
                <label for="bairro">Bairro:</label>
                <input type="text" v-model="pessoa.endereco.bairro" class="form-control" id="bairro" required />
            </div>

            <div class="mb-3">
                <label for="estado">Estado:</label>
                <select v-model="pessoa.endereco.estado" class="form-control" id="estado" required>
                    <option value="">Selecione o estado</option>
                    <option v-for="uf in estados" :key="uf" :value="uf">{{ uf }}</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="cidade">Cidade:</label>
                <input type="text" v-model="pessoa.endereco.cidade" class="form-control" id="cidade" required />
            </div>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-success w-100">Salvar Dados</button>
        </div>
    </form>
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
                .get(`/api/pessoas/${this.id}`)
                .then((res) => {
                    this.pessoa = res.data;
                    if (!this.pessoa.endereco) this.pessoa.endereco = {};
                })
                .catch((err) => {
                    console.error("Erro ao carregar dados:", err);
                    alert("Não foi possível carregar os dados");
                });
        },
        atualizarPessoa() {
            axios
                .put(`/admin/${this.id}`, this.pessoa)
                .then(() => {
                    alert("Dados atualizados com sucesso!");
                    window.location.href = "/lista"; // 👈 Troquei pra redirecionar via window
                })
                .catch((err) => {
                    console.error("Erro na atualização:", err);
                    alert("Erro ao salvar dados");
                });
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
                    alert("Erro ao consultar CEP");
                });
        },
        somenteNumeros(event) {
            event.target.value = event.target.value.replace(/\D/g, "");
            this.pessoa.endereco.numero = event.target.value;
        },
    },
};
</script>