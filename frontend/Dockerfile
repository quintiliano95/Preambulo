# Usa a imagem do Node.js para build do Vue.js
FROM node:18-alpine as build-stage

WORKDIR /app

COPY . .

RUN npm install && npm run build

FROM nginx:alpine

COPY --from=build-stage /app/dist /usr/share/nginx/html

EXPOSE 80
