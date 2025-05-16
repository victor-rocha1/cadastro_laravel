<template>
  <div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h1 class="mb-0">Listagem de Pessoas</h1>
      <a href="/admin/restore" class="btn btn-info btn-sm d-flex align-items-center">
        <i class="fas fa-history me-2"></i> Histórico de Excluídos
      </a>
    </div>

    <div v-if="successMessage" class="alert alert-success text-center">
      {{ successMessage }}
    </div>

    <div v-if="pessoas.length === 0" class="text-center text-danger">
      <p>Nenhuma pessoa cadastrada.</p>
    </div>

    <div v-else class="row justify-content-center mt-4">
      <div
        v-for="pessoa in pessoas"
        :key="pessoa.id"
        class="col-12 col-md-6 col-lg-4 mb-4"
      >
        <div class="card h-100">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0 d-flex align-items-center gap-2 flex-wrap">
              {{ pessoa.nome }}

              <form
                v-if="pessoa.deleted_at"
                :action="`/admin/restore/${pessoa.id}`"
                method="POST"
                class="d-inline ms-3"
              >
                <button type="submit" class="btn btn-secondary btn-sm d-flex align-items-center">
                  <i class="fas fa-history me-1"></i> Restaurar
                </button>
              </form>
            </h5>
          </div>
          <div class="card-body">
            <p><strong>Email:</strong> {{ pessoa.email }}</p>
            <p><strong>CPF:</strong> {{ pessoa.cpf }}</p>
          </div>
          <div class="card-footer d-flex gap-2">
            <a
              :href="`/admin/${pessoa.id}/edit`"
              class="btn btn-warning btn-sm d-flex align-items-center"
              title="Editar"
            >
              <i class="fas fa-edit"></i>
            </a>

            <form
              :action="`/admin/${pessoa.id}`"
              method="POST"
              @submit.prevent="confirmDelete($event, pessoa.id)"
            >
              <input type="hidden" name="_method" value="DELETE" />
              <button
                type="submit"
                class="btn btn-danger btn-sm d-flex align-items-center"
                title="Excluir"
              >
                <i class="fas fa-trash"></i>
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <a href="/" class="btn btn-secondary mt-3 d-inline-flex align-items-center">
      <i class="fas fa-arrow-left me-2"></i> Voltar para a Página Inicial
    </a>
  </div>
</template>

<script>
export default {
  data() {
    return {
      pessoas: [],
      successMessage: '',
    };
  },
  mounted() {
    this.pessoas = window.pessoas || [];
    this.successMessage = window.successMessage || '';
  },
  methods: {
    confirmDelete(event, id) {
      if (confirm('Tem certeza que deseja excluir esta pessoa?')) {
        event.target.submit();
      }
    },
  },
};
</script>