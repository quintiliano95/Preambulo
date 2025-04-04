<template>
  <div class="container mt-5">
    <h2 class="mb-4 text-center">Lista de Registros</h2>

    <div class="row mb-3">
      <div class="col-md-6">
        <input
          type="text"
          class="form-control"
          v-model="searchQuery"
          placeholder="Pesquisar por nome ou CPF..."
        />
      </div>
      <div class="col-md-6 text-end">
        <button class="btn btn-danger" @click="truncateTable">
          Zerar Registros
        </button>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered table-striped table-hover">
        <thead class="table-light">
          <tr>
            <th>Nome</th>
            <th>CPF</th>
            <th>Data Vencimento</th>
            <th>Valor Parcela</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="record in filteredRecords" :key="record.id">
            <td>{{ record.nome }}</td>
            <td>{{ record.cpf }}</td>
            <td>{{ formatDate(record.data_vencimento) }}</td>
            <td>{{ formatCurrency(record.valor_parcela) }}</td>
            <td>
              <button
                class="btn btn-sm btn-primary me-2"
                @click="editRecord(record.id)"
              >
                Editar
              </button>
              <button
                class="btn btn-sm btn-danger"
                @click="deleteRecord(record.id)"
              >
                Excluir
              </button>
            </td>
          </tr>
          <tr v-if="filteredRecords.length === 0">
            <td colspan="5" class="text-center">Nenhum registro encontrado.</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "ListRecords",
  data() {
    return {
      records: [],
      searchQuery: "",
    };
  },
  computed: {
    filteredRecords() {
      return this.records.filter((record) =>
        record.nome.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
        record.cpf.includes(this.searchQuery)
      );
    },
  },
  methods: {
    async fetchRecords() {
      try {
        const response = await axios.get("http://localhost:8080/api.php?action=list");
        this.records = response.data;
      } catch (error) {
        console.error("Erro ao buscar registros:", error);
      }
    },
    async truncateTable() {
      if (confirm("Tem certeza que deseja apagar todos os registros?")) {
        try {
          await axios.get("http://localhost:8080/api.php?action=truncate");
          this.records = [];
        } catch (error) {
          console.error("Erro ao truncar tabela:", error);
        }
      }
    },
    formatDate(date) {
      return new Date(date).toLocaleDateString("pt-BR");
    },
    formatCurrency(value) {
      return new Intl.NumberFormat("pt-BR", {
        style: "currency",
        currency: "BRL",
      }).format(value);
    },
    editRecord(id) {
      this.$router.push({ name: "EditRecord", params: { id } });
    },
    async deleteRecord(id) {
      if (confirm("Deseja excluir este registro?")) {
        await axios.get(`http://localhost:8080/api.php?action=delete&id=${id}`);
        this.fetchRecords();
      }
    },
  },
  mounted() {
    this.fetchRecords();
  },
};
</script>
