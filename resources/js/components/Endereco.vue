<template>
  <div class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="card p-4 shadow-lg border-0" style="width: 100%; max-width: 500px; border-radius: 12px;">

      <div v-if="successMessage" class="alert alert-success text-center">
        {{ successMessage }}
      </div>

      <form @submit.prevent="submitForm">
        <input type="hidden" v-model="form.id_pessoa" />

        <div class="mb-3">
          <label for="cep" class="form-label fw-bold">CEP:</label>
          <input type="text" id="cep" v-model="form.cep" class="form-control" required maxlength="10"
            placeholder="00000-000" @blur="consultarCEP" />
        </div>

        <div class="mb-3">
          <label for="logradouro" class="form-label fw-bold">Logradouro:</label>
          <input type="text" id="logradouro" v-model="form.logradouro" class="form-control" required />
        </div>

        <div class="mb-3">
          <label for="numero" class="form-label fw-bold">Número:</label>
          <input type="text" id="numero" v-model="form.numero" class="form-control" required maxlength="4"
            placeholder="00" />
        </div>

        <div class="mb-3">
          <label for="complemento" class="form-label fw-bold">Complemento:</label>
          <input type="text" id="complemento" v-model="form.complemento" class="form-control" />
        </div>

        <div class="mb-3">
          <label for="bairro" class="form-label fw-bold">Bairro:</label>
          <input type="text" id="bairro" v-model="form.bairro" class="form-control" required />
        </div>

        <div class="mb-3">
          <label for="estado" class="form-label fw-bold">Estado:</label>
          <select id="estado" v-model="form.estado" class="form-control" required>
            <option value="">Selecione o estado</option>
            <option v-for="estado in estados" :key="estado" :value="estado">
              {{ estado }}
            </option>
          </select>
        </div>

        <div class="mb-3">
          <label for="cidade" class="form-label fw-bold">Cidade:</label>
          <input type="text" id="cidade" v-model="form.cidade" class="form-control" required />
        </div>

        <div class="d-flex justify-content-between">
          <button type="button" class="btn btn-secondary" @click="voltar">Voltar</button>
          <button type="submit" class="btn btn-success">Finalizar Cadastro</button>
        </div>
      </form>

    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: {
    idPessoa: {
      type: [String, Number],
      default: ''
    }
  },
  data() {
    return {
      form: {
        id_pessoa: this.idPessoa,
        cep: '',
        logradouro: '',
        numero: '',
        complemento: '',
        bairro: '',
        estado: '',
        cidade: ''
      },
      successMessage: '',
      estados: [
        'AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT',
        'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO',
        'RR', 'SC', 'SP', 'SE', 'TO'
      ]
    };
  },
  methods: {
    consultarCEP() {
      if (this.form.cep.length < 8) return;
      // Exemplo fake de consulta, substitua pelo seu endpoint real se tiver
      axios.get(`https://viacep.com.br/ws/${this.form.cep}/json/`)
        .then(response => {
          if (!response.data.erro) {
            this.form.logradouro = response.data.logradouro || '';
            this.form.bairro = response.data.bairro || '';
            this.form.cidade = response.data.localidade || '';
            this.form.estado = response.data.uf || '';
          } else {
            alert('CEP não encontrado.');
          }
        })
        .catch(() => {
          alert('Erro ao consultar o CEP.');
        });
    },
    submitForm() {
      axios.post('/api/cadastro/endereco', this.form)
        .then(response => {
          this.successMessage = 'Endereço cadastrado com sucesso!';
          this.resetForm();
        })
        .catch(error => {
          console.error(error);
          alert('Erro ao cadastrar o endereço.');
        });
    },
    resetForm() {
      this.form = {
        id_pessoa: this.idPessoa,
        cep: '',
        logradouro: '',
        numero: '',
        complemento: '',
        bairro: '',
        estado: '',
        cidade: ''
      };
    },
    voltar() {
      history.back();
    }
  }
};
</script>
