<template>
  <div class="container">
    <h2>Editar Registro</h2>
    <form @submit.prevent="updateRecord">
      <label>Nome:</label>
      <input type="text" v-model="record.nome" required />

      <label>CPF:</label>
      <input type="text" v-model="record.cpf" required />

      <button type="submit">Atualizar</button>
    </form>
    <p v-if="message">{{ message }}</p>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      record: { nome: "", cpf: "" }, // Definir um objeto inicial
      message: "",
    };
  },
  methods: {
    async fetchRecord() {
      const id = this.$route.params.id;
      if (!id) {
        console.error("ID não encontrado na URL.");
        this.message = "ID não encontrado na URL.";
        return;
      }

      try {
        const response = await axios.get(`http://localhost/Preambulo/backend/api.php?action=list&id=${id}`);
        console.log("Dados carregados:", response.data); // Debug
        this.record = response.data;
      } catch (error) {
        console.error("Erro ao buscar registro:", error);
        this.message = "Erro ao buscar registro.";
      }
    },
    async updateRecord() {
      if (!this.record.id) {
        console.error("Erro: ID não informado antes do envio.", this.record);
        this.message = "Erro: ID não informado.";
        return;
      }

      try {
        console.log("Enviando dados para API:", this.record); // Debug

        const response = await axios.post(
          "http://localhost/Preambulo/backend/api.php?action=update",
          JSON.stringify(this.record),
          { headers: { "Content-Type": "application/json" } }
        );

        console.log("Resposta da API:", response.data);
        this.message = "Registro atualizado com sucesso!";
      } catch (error) {
        console.error("Erro ao atualizar:", error.response ? error.response.data : error);
        this.message = "Erro ao atualizar.";
      }
    }

  },
  mounted() {
    this.fetchRecord();
  },
};
</script>

<style scoped>
.container {
  text-align: center;
  margin: 20px;
}
form {
  display: flex;
  flex-direction: column;
  max-width: 300px;
  margin: auto;
}
input {
  margin-bottom: 10px;
}
</style>
