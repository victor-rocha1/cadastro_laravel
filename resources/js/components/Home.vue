<template>
  <div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <span class="txt">Bem-vindo, Usuário</span>
      <form class="logout-form">
        <button type="button" class="btn btn-danger logout-btn">Sair</button>
      </form>
    </div>

    <h1 class="text-center">Sistema de Cadastro</h1>

    <div class="container mt-4">
      <div class="d-flex justify-content-center">
        <div class="card col-md-6 p-4">
          <h2 class="mb-4 text-center">Pesquisar Cadastro</h2>

          <form @submit.prevent="pesquisar">
            <div class="mb-3">
              <label for="pesquisar" class="form-label fw-bold">Pesquisar por nome ou CPF:</label>
              <input type="text" id="pesquisar" v-model="filtro" class="form-control"
                placeholder="Digite o nome ou CPF" />
            </div>
            <button type="submit" class="btn btn-info w-100">
              <i class="fas fa-search"></i> Pesquisar
            </button>
          </form>

          <div v-if="pessoas.length > 0" class="mt-3">
            <div class="card mb-3" v-for="(pessoa, index) in pessoas" :key="index">
              <div class="card-body">
                <h5 class="card-title">{{ pessoa.nome }}</h5>
                <p class="card-text"><strong>E-mail:</strong> {{ pessoa.email }}</p>
              </div>
            </div>
          </div>
          <div v-else-if="pesquisado" class="alert alert-danger text-center mt-3">
            Nenhum cadastro encontrado.
          </div>

          <div class="mt-5" v-if="true">
            <button class="btn btn-primary w-100 mb-3">
              <i class="fas fa-list"></i> Listar Cadastros
            </button>

            <button class="btn btn-success w-100">
              <i class="fas fa-user-plus"></i> Realizar Novo Cadastro
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
  name: 'App',
  data() {
    return {
      filtro: '',
      pessoas: [],
      pesquisado: false
    };
  },
  methods: {
    async pesquisar() {
      this.pesquisado = false;
      try {
        const response = await axios.get(`/api/pesquisar`, {
          params: { pesquisar: this.filtro }
        });

        this.pessoas = response.data;
      } catch (error) {
        console.error('Erro ao buscar pessoas:', error);
        this.pessoas = [];
      } finally {
        this.pesquisado = true;
      }
    }
  }
};

</script>

<style scoped>
.txt,
.logout-btn {
  border-radius: 8px;
  padding: 8px 15px;
  height: 45px;
  display: flex;
  align-items: center;
}

.txt {
  background: rgba(255, 255, 255, 0.8);
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.logout-btn {
  justify-content: center;
}

.logout-form {
  margin: 0;
}
</style>