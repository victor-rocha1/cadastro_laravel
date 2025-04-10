<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="380" alt="Laravel Logo">
  </a>
</p>

<h1 align="center">📋 Sistema de Cadastro de Pessoas - Laravel</h1>

<p align="center">
  Projeto completo com autenticação, controle de acesso, cadastro de pessoas e múltiplos endereços, utilizando Laravel, Bootstrap e integração com API de CEP.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-10.x-red?style=flat&logo=laravel">
  <img src="https://img.shields.io/badge/PHP-8.x-blue?style=flat&logo=php">
  <img src="https://img.shields.io/badge/MySQL-Database-blue?style=flat&logo=mysql">
  <img src="https://img.shields.io/badge/License-MIT-green">
</p>

---

## 📌 Visão Geral

Este projeto foi desenvolvido com o objetivo de gerenciar cadastros de pessoas físicas, com possibilidade de adicionar múltiplos endereços (residencial e comercial), realizar buscas por nome ou CPF, e controlar o acesso ao sistema com base no tipo de usuário.

O sistema foi construído com base na arquitetura MVC (Model-View-Controller) e segue boas práticas de organização, modularização de código e usabilidade.

---

## ✅ Funcionalidades

### Autenticação de usuários com dois tipos de acesso:
  - 👤 **Usuário Comum**: acesso restrito
  - 🛠️ **Administrador**: acesso completo (cadastrar, editar, excluir e restaurar dados)
### Cadastro de pessoas com os seguintes dados:
  - Nome, Nome Social, CPF, Nome do Pai, Nome da Mãe, Telefone, Email
### Cadastro de endereços:
  - CEP, logradouro, número, complemento, bairro, estado e cidade
  - Preenchimento automático via integração com a [API ViaCEP](https://viacep.com.br)
### Pesquisa de pessoas por nome ou CPF
- Máscara e validação de CPF
- Separação de scripts JavaScript por responsabilidade
- Design responsivo com Bootstrap

---

## 🧱 Estrutura de Pastas

```
CADASTRO_LARAVEL/
├── app/
│   ├── Console/
│   ├── Exceptions/
│   └── Http/
│       ├── Controllers/
│       ├── Middleware/
│       └── Kernel.php
├── bootstrap/
├── config/
├── database/
├── node_modules/
├── public/
├── resources/
│   ├── js/          # Scripts separados
│   ├── lang/
│   └── views/       # Views Blade
├── routes/
│   └── web.php      # Arquivo de rotas principais
├── storage/
├── tests/
├── vendor/
├── .env
├── .env.example
├── artisan
├── composer.json
├── package.json
├── README.md
├── server.php
├── webpack.mix.js
```

---

## 🚀 Como Executar o Projeto

> **Pré-requisitos:** PHP 8.x, Composer, MySQL, Node.js (opcional para frontend)

1. Clone o repositório:
```bash
git clone https://github.com/seu-usuario/seu-repositorio.git
cd seu-repositorio
```

2. Instale as dependências PHP:
```bash
composer install
```

3. Instale as dependências frontend (se necessário):
```bash
npm install && npm run dev
```

4. Copie o arquivo `.env.example` para `.env` e configure:
```bash
cp .env.example .env
php artisan key:generate
```

5. Configure seu banco de dados no `.env` e rode as migrations:
```bash
php artisan migrate
```

6. Inicie o servidor local:
```bash
php artisan serve
```

---

## 👨‍💻 Tecnologias Utilizadas

- [Laravel](https://laravel.com/)
- [PHP](https://www.php.net/)
- [MySQL](https://www.mysql.com/)
- [Bootstrap](https://getbootstrap.com/)
- [JavaScript](https://developer.mozilla.org/pt-BR/docs/Web/JavaScript)
- [ViaCEP API](https://viacep.com.br)

---

## 👮‍♂️ Controle de Acesso

- **Administrador:** acesso total ao sistema
- **Usuário Comum:** acesso limitado (apenas leitura)

Todas as rotas sensíveis são protegidas para garantir a integridade dos dados e segurança da aplicação.

---

## 🤝 Contribuindo

Contribuições são muito bem-vindas!  
Abra uma _issue_, envie um _pull request_ ou sugira melhorias.

---

## 🛡️ Licença

Este projeto está licenciado sob a [MIT License](https://opensource.org/licenses/MIT).
