<template>
  <div class="container mt-5">
    <h2 class="mb-4 text-center">Editar Registro</h2>

    <form @submit.prevent="updateRecord" class="border p-4 shadow-sm rounded bg-white">
      <div class="mb-3" v-for="(label, key) in labels" :key="key">
        <label :for="key" class="form-label">{{ label }}:</label>

        <input
          v-if="key === 'data_vencimento'"
          type="date"
          class="form-control"
          :id="key"
          v-model="record[key]"
          :class="{ 'is-invalid': errors[key] }"
          required
        />

        <input
          v-else-if="key === 'valor_parcela'"
          type="number"
          step="0.01"
          class="form-control"
          :id="key"
          v-model="record[key]"
          :class="{ 'is-invalid': errors[key] }"
          required
        />

        <input
          v-else
          type="text"
          class="form-control"
          :id="key"
          v-model="record[key]"
          :class="{ 'is-invalid': errors[key] }"
          required
        />

        <div v-if="errors[key]" class="invalid-feedback">
          {{ errors[key] }}
        </div>
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
      errors: {},
      labels: {
        nome: "Nome",
        cpf: "CPF",
        endereco: "Endereço",
        bairro: "Bairro",
        cidade: "Cidade",
        estado: "Estado (UF)",
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

    validateFields() {
      this.errors = {};

      if (!this.record.nome.trim()) this.errors.nome = "Nome é obrigatório.";
      if (!/^\d{11}$/.test(this.record.cpf)) this.errors.cpf = "CPF deve conter 11 dígitos sendo números.";
      if (!this.record.endereco.trim()) this.errors.endereco = "Endereço é obrigatório.";
      if (!this.record.bairro.trim()) this.errors.bairro = "Bairro é obrigatório.";
      if (!this.record.cidade.trim()) this.errors.cidade = "Cidade é obrigatória.";
      if (!/^[A-Z]{2}$/i.test(this.record.estado)) this.errors.estado = "Estado deve ter 2 letras.";
      // if (!/^\d{10,11}$/.test(this.record.telefone)) this.errors.telefone = "Telefone deve ter 10 ou 11 dígitos.";
      if (!/^[^@]+@[^@]+\.[^@]+$/.test(this.record.email)) this.errors.email = "Email inválido.";
      if (!Number.isInteger(Number(this.record.numero_parcela)) || this.record.numero_parcela <= 0)
        this.errors.numero_parcela = "Número da parcela deve ser um número inteiro positivo.";
      if (!this.record.contrato.trim()) this.errors.contrato = "Contrato é obrigatório.";
      if (!this.record.data_vencimento) this.errors.data_vencimento = "Data de vencimento é obrigatória.";
      if (!this.record.valor_parcela || this.record.valor_parcela <= 0)
        this.errors.valor_parcela = "Valor da parcela deve ser maior que 0.";

      return Object.keys(this.errors).length === 0;
    },

    async updateRecord() {
      if (!this.record.id) {
        this.message = "Erro: ID não informado.";
        return;
      }

      if (!this.validateFields()) {
        this.message = "Corrija os erros antes de enviar.";
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
