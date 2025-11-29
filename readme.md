# Gestão de Pessoas

Como rodar o projeto:

1. Clone ou extraia este repositório dentro da pasta raiz do seu servidor PHP local.
   ex.: C:\xampp\htdocs\gestao-pessoas

2. Na raiz do projeto, crie um arquivo chamado `.env` e configure seu banco de dados (copie o modelo do arquivo .env.example se houver).

   Exemplo de conteúdo do .env:
   DB_HOST=localhost
   DB_NAME=db_gestao
   DB_USER=root
   DB_PASS=

3. Para criar o banco de dados e a tabela automaticamente, acesse no navegador:
   http://localhost/gestao-pessoas/public/setup.php

4. Para abrir o sistema:
   http://localhost/gestao-pessoas/public/
