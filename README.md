# CRUD-PHP-7.4

## Requisitos

Banco de dados MySQL
PHP 7.4

## Instruções de uso

1 - Abra o arquivo [config.ini](https://github.com/gustavokuhl/CRUD-PHP-7.4/blob/main/src/Infraestrutura/config.ini) e edite os dados de acesso ao banco

2 - Crie um schema chamado `magazord` no MySQL

3 - Execute o comando `composer install` para instalar as dependências

4 - Execute o comando `php vendor/bin/doctrine orm:schema-tool:create`

5 - Execute o projeto com o comando `php -S localhost:8000 -t public`