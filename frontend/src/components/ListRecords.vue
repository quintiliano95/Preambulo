<template>
  <div class="container">
    <h2>Lista de Registros</h2>
    <input type="text" v-model="searchQuery" placeholder="Pesquisar..." />
    <table>
      <thead>
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
            <button @click="editRecord(record.id)">Editar</button>
            <button @click="deleteRecord(record.id)">Excluir</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      records: [],
      searchQuery: "",
    };
  },
  computed: {
    filteredRecords() {
      return this.records.filter(record =>
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
    formatDate(date) {
      return new Date(date).toLocaleDateString("pt-BR");
    },
    formatCurrency(value) {
      return new Intl.NumberFormat("pt-BR", { style: "currency", currency: "BRL" }).format(value);
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

<style scoped>
.container {
  text-align: center;
  margin: 20px;
}
table {
  width: 100%;
  border-collapse: collapse;
}
th, td {
  padding: 8px;
  border: 1px solid #ddd;
}
</style>
