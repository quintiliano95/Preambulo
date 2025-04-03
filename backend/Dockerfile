# Usa a imagem oficial do PHP com Apache
FROM php:7.4-apache

# Instala extensões necessárias (ajuste conforme o projeto precisar)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copia o código do backend para dentro do container
COPY . /var/www/html

# Expõe a porta 80 para o servidor Apache
EXPOSE 80
