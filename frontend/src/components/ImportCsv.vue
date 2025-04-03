<template>
  <div class="container">
    <h2>Importar CSV</h2>
    <input type="file" @change="handleFileUpload" accept=".csv" />
    <button @click="uploadCsv">Enviar</button>
    <p v-if="message">{{ message }}</p>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      file: null,
      message: "",
    };
  },
  methods: {
    handleFileUpload(event) {
      this.file = event.target.files[0];
    },
    async uploadCsv() {
      if (!this.file) {
        this.message = "Selecione um arquivo CSV.";
        return;
      }

      const formData = new FormData();
      formData.append("csv_file", this.file);

      try {
        const response = await axios.post("http://localhost:8080/import.php", formData);
        this.message = "Importação concluída!";
      } catch (error) {
        this.message = "Erro ao importar CSV.";
      }
    },
  },
};
</script>

<style scoped>
.container {
  text-align: center;
  margin: 20px;
}
</style>
