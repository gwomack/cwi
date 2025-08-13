## Teste WCI

### Objetivo
Criar uma aplicação Laravel simples com:
- CRUD de usuários (nome, email, senha)
- Um endpoint /health (para simular um microsserviço vivo)
- Um consumo básico de um microsserviço feito em Node.js (mock simples em Node Express)
- Criar uma tabela users com os campos:
  - id
  - name
  - email
  - password
- Criar as rotas para:
  - GET /users
  - POST /users
  - GET /users/{id}
  - PUT /users/{id}
  - DELETE /users/{id}
- Criar o endpoint GET /health que retorna { "status": "ok" }
- Criar uma rota GET /external que faz uma requisição para um endpoint do microsserviço Node.js e retorna o valor na resposta.
- A inserção da resposta do teste deverá ocorrer em um GitHub público.

## Instruções para Execução Local

### Requisitos

#### Aplicação Laravel
- PHP 8.2 ou superior
- Composer
- MySQL (ou outro banco de dados compatível)
- Node.js e NPM (para os assets)

#### Microsserviço Node.js
- Node.js (versão recomendada: LTS atual)
- NPM ou Yarn

### Passos para Execução

#### Configuração da Aplicação Laravel

1. Clone o repositório
   ```bash
   git clone [URL_DO_REPOSITÓRIO]
   cd cwi
   ```

2. Acesse o diretório da aplicação Laravel
   ```bash
   cd laravel
   ```

3. Instale as dependências do Composer
   ```bash
   composer install
   ```

4. Copie o arquivo de ambiente e gere a chave da aplicação
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. Configure o banco de dados no arquivo .env
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=cwi_laravel
   DB_USERNAME=seu_usuario
   DB_PASSWORD=sua_senha
   ```

6. Execute as migrações do banco de dados
   ```bash
   php artisan migrate
   ```

7. Inicie o servidor de desenvolvimento
   ```bash
   php artisan serve
   ```
   A aplicação estará disponível em http://localhost:8000
   

#### Configuração do Microsserviço Node.js

1. Acesse o diretório do microsserviço Node.js
   ```bash
   cd ../node
   ```

2. Instale as dependências
   ```bash
   npm install
   ```

3. Copie o arquivo de ambiente
   ```bash
   cp .env.example .env
   ```

4. Inicie o servidor Node.js
   ```bash
   npm start
   ```
   O microsserviço estará disponível em http://localhost:3000

#### finalizando as configurações

1. Gere chave de comunicação dos sistemas
   ```bash
   curl -X POST http://localhost:8000/token -H "Content-Type: application/json" -d '{"system_name":"node","secret_key":"sua_chave"}'
   ```
   Inserir chave gerada nos arquivos .env de ambos os microsserviços com chave TOKEN=chave_gerada_aqui

2. configure os arquivos .env
   ```
   # laravel/.env
   M2M_SECRET_KEY=sua_chave
   TOKEN=chave_gerada_aqui
   NODE_URL=http://localhost:3000
  
   # node/.env
   TOKEN=chave_gerada_aqui
   ```