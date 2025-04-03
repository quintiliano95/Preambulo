# Usa a imagem do Node.js para build do Vue.js
FROM node:18-alpine as build-stage

WORKDIR /app

# Copia o código do Vue.js
COPY . .

# Instala dependências e compila
RUN npm install && npm run build

# Usa uma imagem leve do Nginx para servir os arquivos estáticos
FROM nginx:alpine

# Copia os arquivos compilados para o servidor Nginx
COPY --from=build-stage /app/dist /usr/share/nginx/html

# Expõe a porta 80
EXPOSE 80
