<template>
  <div class="container mt-5">
    <h2 class="mb-4 text-center">Editar Registro</h2>

    <form @submit.prevent="updateRecord" class="border p-4 shadow-sm rounded bg-white">
      <div class="mb-3">
        <label for="nome" class="form-label">Nome:</label>
        <input
          type="text"
          id="nome"
          v-model="record.nome"
          class="form-control"
          required
        />
      </div>

      <div class="mb-3">
        <label for="cpf" class="form-label">CPF:</label>
        <input
          type="text"
          id="cpf"
          v-model="record.cpf"
          class="form-control"
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
      record: { nome: "", cpf: "" },
      message: "",
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
    },
  },
  mounted() {
    this.fetchRecord();
  },
};
</script>

<style scoped>
.container {
  max-width: 600px;
}
</style>
