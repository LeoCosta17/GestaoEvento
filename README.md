# EventosPro - Sistema de Gestão de Eventos

Uma plataforma completa de criação e descoberta de eventos. O sistema atende a dois tipos de públicos: **Organizadores (PJ)**, que criam e gerenciam seus eventos, e **Usuários Comuns (PF)**, que buscam eventos futuros e realizam suas inscrições.

O sistema foi desenhado visando performance e código limpo, sem utilização de grandes frameworks PHP ou Node.js, mantendo a leveza de um backend puramente nativo (Vanilla PHP) e de um frontend Single Page Application (SPA) em Vanilla JS.

---

## 🚀 Tecnologias Utilizadas

### Backend (API)
- **PHP 8+**: Lógica de servidor com forte separação de responsabilidades.
- **Arquitetura MVC & Layered**: Repositórios (acesso a dados), Serviços (regras de negócio) e Controladores (transporte HTTP).
- **MariaDB / MySQL**: Banco de Dados Relacional.
- **PDO**: Acesso seguro ao banco de dados nativo do PHP, prevenindo SQL Injection.
- **Autenticação JWT (JSON Web Tokens)**: Implementação customizada de tokens, eliminando sessões estatais e garantindo rotas protegidas (Stateless).

### Frontend
- **Vanilla JavaScript**: Fetch API nativa para comunicação assíncrona, manipulação direta do DOM via modularização e eventos.
- **Componentização com PHP**: Interface modular (`login.php`, `dashboard_pj.php`), que facilita manutenção sem a necessidade de React ou Vue.
- **Tailwind CSS (via CDN)**: Estilização moderna, responsiva, com uso extensivo de utilitários flexbox, grids, tipografia avançada e efeitos glassmorphism.

---

## ⚙️ Regras de Negócio

1. **Tipos de Acesso**
   - **PF (Pessoa Física)**: Autentica com CPF, visualiza apenas eventos **futuros** e pode realizar 1 (uma) inscrição por evento.
   - **PJ (Pessoa Jurídica)**: Autentica com CNPJ, não pode se inscrever em eventos. Somente PJs possuem a permissão para criar eventos e visualizar o total de inscritos neles.

2. **Filtro de Inscrição Única**
   - O banco de dados aplica `UNIQUE KEY` travando múltiplas inscrições. O frontend exibe de forma reativa o status **"Inscrito"** em eventos que o usuário PF já garantiu vaga.

3. **Exibição Dinâmica (SPA)**
   - O frontend realiza a transição do login para o Dashboard sem recarregar a página (Single Page Application), injetando views de forma limpa.

---

## 🛠️ Instruções de Instalação e Execução

### 1. Preparação do Banco de Dados
1. Inicie seu servidor MariaDB / MySQL (ex: XAMPP, WAMP, Docker).
2. O arquivo `database.sql` contém todo o schema. Execute-o no seu SGBD (phpMyAdmin ou DBeaver) para criar o banco de dados `cadeventos` e as tabelas necessárias.

### 2. Configurações
1. Caso seu banco de dados possua senha, porta ou nome de usuário diferentes, abra o arquivo `api/config/Database.php` e ajuste as propriedades privadas da classe:
   ```php
   private $host = "localhost";
   private $db_name = "cadeventos";
   private $username = "root";
   private $password = "12345";
   private $port = "3307";
   ```

### 3. Rodando a Aplicação
O sistema possui um **Roteador Unificado** (`router.php`). Isso significa que com apenas um servidor você terá acesso tanto à interface quanto à API.

Abra o terminal, navegue até a raiz do projeto e inicie o servidor embutido do PHP apontando para a pasta `public`:

```bash
cd c:\dev\Prova0106\public
php -S localhost:8000 router.php
```

Acesse **`http://localhost:8000`** no seu navegador web.
> **Nota:** As requisições de API feitas pelo Javascript apontarão automaticamente para `http://localhost:8000/api/...` graças ao roteador.

---

## 📖 Documentação da API REST

A API se comunica estritamente via JSON. Caso acesse endpoints protegidos, adicione o header:
`Authorization: Bearer <SEU_TOKEN_AQUI>`

### Endpoints Públicos
- `POST /api/register`: Cria um usuário.
  - **Payload:** `{"type": "PF", "name": "...", "document": "...", "email": "...", "password": "..."}`
- `POST /api/login`: Autentica um usuário e retorna o token JWT.
  - **Payload:** `{"email": "...", "password": "..."}`
- `GET /api/events`: Retorna todos os eventos futuros.

### Endpoints Protegidos (Requerem JWT)
- **Organizador (PJ):**
  - `POST /api/events`: Cria um novo evento.
  - `GET /api/my-events`: Lista os eventos criados pelo usuário logado com as respectivas contagens de inscrições.
- **Usuário Comum (PF):**
  - `GET /api/subscriptions`: Retorna os eventos em que o usuário logado está inscrito.
  - `POST /api/events/{id}/subscribe`: Realiza a inscrição em um evento específico.
  - `POST /api/events/{id}/unsubscribe`: Cancela a inscrição de um evento específico.

---

## 📁 Estrutura de Diretórios

```text
c:\dev\Prova0106
├── database.sql                  # Schema inicial do banco de dados
├── api/                          # Backend em PHP puro
│   ├── config/
│   │   └── Database.php          # Configuração PDO
│   ├── public/
│   │   └── index.php             # Ponto de entrada do backend (Roteador de API)
│   └── src/
│       ├── Controllers/          # Controladores (Auth, Event, Subscription)
│       ├── Repositories/         # Interação com BD via SQL Nativo
│       ├── Services/             # Lógica e validação de regras de negócio
│       └── Utils/                # Ferramentas auxiliares (Response, JwtHandler)
└── public/                       # Frontend e arquivos públicos
    ├── index.php                 # Ponto de entrada e esqueleto (Shell) do Frontend
    ├── router.php                # Roteador unificado para o servidor do PHP
    ├── assets/
    │   └── js/                   # Lógica modular do Frontend (api.js, ui.js, auth.js, etc.)
    └── components/               # Partes injetáveis do HTML/PHP (login, sidebar, dashboards)
```

---
*Desenvolvido seguindo boas práticas de clean code.*
