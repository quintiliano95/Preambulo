<template>
  <div id="app">
    <nav class="navbar">
      <router-link to="/" class="nav-link">Importar CSV</router-link>
      <router-link to="/records" class="nav-link">Listar Registros</router-link>
    </nav>

    <div class="container">
      <router-view @refresh-data="refreshData"></router-view>
    </div>

    <!-- <notification-center :notifications="notifications" @remove-notification="removeNotification"></notification-center> -->
  </div>
</template>

<!-- <script>
// import NotificationCenter from '@/components/NotificationCenter.vue'

export default {
  name: 'App',
  components: {
    // NotificationCenter
  },
  data() {
    return {
    //   notifications: []
    }
  },
  methods: {
    addNotification(type, message) {
      const id = Date.now()
      this.notifications.push({ id, type, message })
      setTimeout(() => this.removeNotification(id), 5000)
    },
    removeNotification(id) {
      this.notifications = this.notifications.filter(n => n.id !== id)
    },
    refreshData() {
      // Evento para ser capturado pelos componentes filhos que precisam atualizar dados
      this.$emit('refresh-data')
    }
  },
  provide() {
    // Disponibiliza métodos para componentes filhos
    return {
      addNotification: this.addNotification,
      formatCpf: this.formatCpf,
      formatPhone: this.formatPhone,
      formatDate: this.formatDate,
      formatCurrency: this.formatCurrency
    }
  },
  methods: {
    // Funções de formatação para serem compartilhadas
    formatCpf(cpf) {
      if (!cpf) return ''
      return cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4')
    },
    formatPhone(phone) {
      if (!phone) return ''
      const nums = phone.replace(/\D/g, '')
      if (nums.length === 11) {
        return nums.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3')
      }
      return nums
    },
    formatDate(date) {
      if (!date) return ''
      const [year, month, day] = date.split('-')
      return `${day}/${month}/${year}`
    },
    formatCurrency(value) {
      if (!value) return 'R$ 0,00'
      return parseFloat(value).toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL'
      })
    },
    parseCurrency(value) {
      if (typeof value === 'number') return value
      return parseFloat(value.replace('R$', '').replace('.', '').replace(',', '.').trim())
    }
  }
}
</script> -->

<style>
/* Estilos globais */
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  line-height: 1.6;
  background-color: #f5f5f5;
  color: #333;
}

#app {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

.navbar {
  background-color: #2c3e50;
  padding: 1rem 2rem;
  display: flex;
  gap: 1rem;
}

.nav-link {
  color: #fff;
  text-decoration: none;
  font-weight: 500;
  padding: 0.5rem 1rem;
  border-radius: 4px;
  transition: background-color 0.3s;
}

.nav-link:hover {
  background-color: #34495e;
}

.nav-link.router-link-exact-active {
  background-color: #42b983;
}

.container {
  max-width: 1200px;
  margin: 2rem auto;
  padding: 0 1rem;
  flex: 1;
}

/* Estilos para formulários e tabelas */
.form-group {
  margin-bottom: 1.5rem;
}

.form-group label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: 600;
}

.form-control {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 1rem;
}

.btn {
  padding: 0.75rem 1.5rem;
  border: none;
  border-radius: 4px;
  font-size: 1rem;
  cursor: pointer;
  transition: background-color 0.3s;
}

.btn-primary {
  background-color: #42b983;
  color: white;
}

.btn-primary:hover {
  background-color: #3aa876;
}

.btn-danger {
  background-color: #e74c3c;
  color: white;
}

.btn-danger:hover {
  background-color: #c0392b;
}

.table {
  width: 100%;
  border-collapse: collapse;
  margin: 1rem 0;
  background-color: white;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.table th,
.table td {
  padding: 1rem;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

.table th {
  background-color: #f8f9fa;
  font-weight: 600;
}

.table tr:hover {
  background-color: #f5f5f5;
}

/* Responsividade */
@media (max-width: 768px) {
  .navbar {
    flex-direction: column;
    gap: 0.5rem;
    padding: 1rem;
  }
  
  .table {
    display: block;
    overflow-x: auto;
  }
}
</style>