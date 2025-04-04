# Projeto Full Stack com Docker: PHP + MySQL + Vue.js

Este projeto é composto por:

- Backend: PHP (versão 5.4)
- Frontend: Vue.js
- Banco de Dados: MySQL
- Ambiente: Docker e Docker Compose

---

## 🚀 Como rodar o projeto

### Pré-requisitos

Antes de tudo, certifique-se de que você tem instalado:

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)

---

### ⚙️ Passo a passo

1. **Clone este repositório:**

```bash
git clone https://github.com/quintiliano95/Preambulo
cd Preambulo
```

2. **Construa e inicie os containers:**

```bash
docker-compose up --build -d
```

Este comando irá:

- Criar os containers para o backend, frontend e banco de dados
- Executar tudo em segundo plano (`-d`)
- Reconstruir as imagens caso necessário (`--build`)

---

## 💻 Acessando o projeto

- **Frontend (Vue.js):** http://localhost:3000
