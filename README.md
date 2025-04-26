# Gerenciador de Chamados

Esta é uma aplicação Laravel para gerenciamento de ordens de serviço (chamados). Este README fornece instruções passo a passo para configurar e executar a aplicação em um ambiente Docker para sistemas operacionais Windows e Linux.

## Pré-requisitos

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)
- Git

## Instruções de Configuração

### Clonar o Repositório

```bash
git clone <repository-url>
cd chamados-manager
```

### Configurando o Ambiente

#### Para Linux/macOS

1. Criar o arquivo .env:

```bash
cd chamados-app
cp .env.example .env  # Se .env.example não existir, criaremos um no próximo passo
```

2. Se .env.example não existir, crie um arquivo .env com o seguinte conteúdo:

```bash
APP_NAME="Chamados-app"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:3000

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=orders
DB_USERNAME=user
DB_PASSWORD=pass

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

3. Retorne à raiz do projeto:

```bash
cd ..
```

#### Para Windows

1. Criar o arquivo .env:

```powershell
cd chamados-app
copy .env.example .env  # Se .env.example não existir, crie-o manualmente
```

2. Se .env.example não existir, crie um arquivo .env com o mesmo conteúdo mostrado na seção Linux acima.

3. Retorne à raiz do projeto:

```powershell
cd ..
```

### Construindo e Iniciando os Contêineres Docker

#### Para Linux/macOS

```bash
docker-compose up -d --build
```

#### Para Windows

```powershell
docker-compose up -d --build
```

### Instalando Dependências e Configurando a Aplicação

#### Para Linux/macOS

1. Entre no contêiner da aplicação:

```bash
docker-compose exec app bash
```

2. Instale as dependências PHP:

```bash
composer install
```

3. Gere a chave da aplicação:

```bash
php artisan key:generate
```

4. Execute as migrações do banco de dados:

```bash
php artisan migrate
```

5. Popule o banco de dados com dados iniciais:

```bash
php artisan db:seed
```


#### Para Windows

1. Entre no contêiner da aplicação:

```powershell
docker-compose exec app bash
```

2. Siga os mesmos passos 2-5 como na seção Linux acima.

3. Saia do contêiner:

```powershell
exit
```

## Acessando a Aplicação

Após completar a configuração, você pode acessar a aplicação em:

- **URL:** http://localhost:3000

## Gerenciamento do Banco de Dados

### Executando Migrações

Para executar migrações dentro do contêiner Docker:

```bash
docker-compose exec app php artisan migrate
```

### Executando Seeders

Para popular o banco de dados com dados iniciais:

```bash
docker-compose exec app php artisan db:seed
```

Para executar um seeder específico:

```bash
docker-compose exec app php artisan db:seed --class=CategorySeeder
docker-compose exec app php artisan db:seed --class=StatusSeeder
docker-compose exec app php artisan db:seed --class=OrdersSeeder
```

## Parando a Aplicação

Para parar os contêineres Docker:

```bash
docker-compose down
```

Para parar e remover todos os contêineres, redes e volumes:

```bash
docker-compose down -v
```
