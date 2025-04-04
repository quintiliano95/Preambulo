<template>
  <div class="container mt-5">
    <div class="card shadow p-4">
      <h2 class="text-center mb-4">Importar CSV</h2>
      
      <div class="mb-3">
        <input
          type="file"
          class="form-control"
          @change="handleFileUpload"
          accept=".csv"
        />
      </div>

      <div class="d-grid gap-2">
        <button class="btn btn-primary" @click="uploadCsv">Enviar</button>
      </div>

      <div class="mt-3 text-center">
        <p v-if="message" class="alert" :class="messageClass">{{ message }}</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      file: null,
      message: "",
      success: false,
    };
  },
  computed: {
    messageClass() {
      return this.success ? "alert-success" : "alert-danger";
    },
  },
  methods: {
    handleFileUpload(event) {
      this.file = event.target.files[0];
    },
    async uploadCsv() {
      if (!this.file) {
        this.message = "Selecione um arquivo CSV.";
        this.success = false;
        return;
      }

      const formData = new FormData();
      formData.append("csv_file", this.file);

      try {
        await axios.post("http://localhost:8080/import.php", formData);
        this.message = "Importação concluída!";
        this.success = true;
      } catch (error) {
        this.message = "Erro ao importar CSV.";
        this.success = false;
      }
    },
  },
};
</script>

<style scoped>
.card {
  max-width: 500px;
  margin: 0 auto;
}
</style>
