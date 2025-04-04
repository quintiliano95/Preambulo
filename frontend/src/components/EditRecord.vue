<template>
  <div class="container mt-5">
    <h2 class="mb-4 text-center">Editar Registro</h2>

    <form @submit.prevent="updateRecord" class="border p-4 shadow-sm rounded bg-white">
      <div class="mb-3" v-for="(label, key) in labels" :key="key">
        <label :for="key" class="form-label">{{ label }}:</label>
        <input
          v-if="key !== 'data_vencimento' && key !== 'valor_parcela'"
          type="text"
          class="form-control"
          :id="key"
          v-model="record[key]"
          required
        />
        <input
          v-else-if="key === 'data_vencimento'"
          type="date"
          class="form-control"
          :id="key"
          v-model="record[key]"
          required
        />
        <input
          v-else-if="key === 'valor_parcela'"
          type="number"
          step="0.01"
          class="form-control"
          :id="key"
          v-model="record[key]"
          required
        />
      </div>

      <button type="submit" class="btn btn-success w-100">Atualizar</button>
    </form>

    <p v-if="message" class="mt-3 alert alert-info text-center">{{ message }}</p>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      record: {
        id: "",
        nome: "",
        cpf: "",
        endereco: "",
        bairro: "",
        cidade: "",
        estado: "",
        telefone: "",
        email: "",
        numero_parcela: null,
        contrato: "",
        data_vencimento: "",
        valor_parcela: null,
        created_at: ""
      },
      message: "",
      labels: {
        nome: "Nome",
        cpf: "CPF",
        endereco: "Endereço",
        bairro: "Bairro",
        cidade: "Cidade",
        estado: "Estado",
        telefone: "Telefone",
        email: "Email",
        numero_parcela: "Número da Parcela",
        contrato: "Contrato",
        data_vencimento: "Data de Vencimento",
        valor_parcela: "Valor da Parcela"
      }
    };
  },
  methods: {
    async fetchRecord() {
      const id = this.$route.params.id;
      if (!id) {
        this.message = "ID não encontrado na URL.";
        return;
      }

      try {
        const response = await axios.get(`http://localhost:8080/api.php?action=list&id=${id}`);
        this.record = response.data;
      } catch (error) {
        console.error("Erro ao buscar registro:", error);
        this.message = "Erro ao buscar registro.";
      }
    },
    async updateRecord() {
      if (!this.record.id) {
        this.message = "Erro: ID não informado.";
        return;
      }

      try {
        await axios.post(
          "http://localhost:8080/api.php?action=update",
          JSON.stringify(this.record),
          { headers: { "Content-Type": "application/json" } }
        );
        this.message = "Registro atualizado com sucesso!";
      } catch (error) {
        console.error("Erro ao atualizar:", error);
        this.message = "Erro ao atualizar.";
      }
    }
  },
  mounted() {
    this.fetchRecord();
  }
};
</script>

<style scoped>
.container {
  max-width: 600px;
}
</style>
