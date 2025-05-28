<template>
  <div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <span class="txt">Bem-vindo, {{ currentUser ? currentUser.name : 'Usuário' }}</span>
      <button type="button" @click="handleLogout" class="btn btn-danger logout-btn">Sair</button>
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

          <div class="mt-5" v-if="isAdmin">
            <button class="btn btn-primary w-100 mb-3" @click="irParaLista">
              <i class="fas fa-list"></i> Listar Cadastros
            </button>

            <button class="btn btn-success w-100" @click="irParaCadastro">
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
  name: 'Home',
  data() {
    return {
      filtro: '',
      pessoas: [],
      pesquisado: false,
      currentUser: null, 
      isAdmin: false,    
    };
  },
  created() {
    this.loadUserData();
  },
  methods: {
    loadUserData() {
      try {
        const userDataString = localStorage.getItem('user');
        const isAdminString = localStorage.getItem('is_admin');

        if (userDataString) {
          this.currentUser = JSON.parse(userDataString);
        }
        if (isAdminString) {
          this.isAdmin = isAdminString === 'true';
        }

        if (!this.currentUser) {
          axios.get('/api/user')
            .then(response => {
              this.currentUser = response.data;
              this.isAdmin = response.data.is_admin;
              localStorage.setItem('user', JSON.stringify(response.data));
              localStorage.setItem('is_admin', response.data.is_admin);
            })
            .catch(() => {
              // Não autenticado ou erro, limpar localStorage e redirecionar
              localStorage.removeItem('user');
              localStorage.removeItem('is_admin');
              window.location.href = '/login';
            });
        }

      } catch (e) {
        console.error("Erro ao carregar dados do usuário do localStorage:", e);
        this.currentUser = null;
        this.isAdmin = false;
      }
    },
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
    },
    irParaLista() {
      window.location.href = '/lista';
    },
    irParaCadastro() {
      window.location.href = '/pessoa';
    },
    async handleLogout() {
      try {
        await axios.post('/api/logout');

        localStorage.removeItem('user');
        localStorage.removeItem('is_admin');

        window.location.href = '/login';
      } catch (error) {
        console.error('Erro ao fazer logout:', error);
        // Mesmo em caso de erro na API, limpa o estado local e redireciona
        localStorage.removeItem('user');
        localStorage.removeItem('is_admin');
        window.location.href = '/login';
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
</style>