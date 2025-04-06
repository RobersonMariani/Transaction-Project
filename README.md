# 💸 Projeto Transaction

Este projeto é uma API RESTful desenvolvida com Laravel 12 para simular transferências entre usuários do tipo `comum` e `lojista`, atendendo aos requisitos de um sistema simplificado de pagamentos.

---

## 🚀 Tecnologias Utilizadas

- PHP 8.3
- Laravel 12
- MySQL 8
- PHPUnit
- Docker + Docker Compose
- GitHub Actions (CI)
- PHPDoc
- PHPStan
- PHP-CS-Fixer
- PSR-4 Autoload
- SOLID Principles
- Design Patterns (Repository, DTO, Service)

---

## 🧩 Estrutura Modular

O projeto foi construído com arquitetura **modular**, onde cada domínio (`User`, `Transaction`) está separado com suas próprias responsabilidades:

```
app/
└── Modules/
    ├── User/
    │   ├── Controllers
    │   ├── DTOs
    │   ├── Models
    │   ├── Repositories
    │   ├── Requests
    │   ├── routes
    │   └── Services
    └── Transaction/
        ├── Controllers
        ├── DTOs
        ├── Exceptions
        ├── Jobs
        ├── Models
        ├── Repositories
        ├── Requests
        ├── routes
        └── Services
```

---

## 📌 Regras de Negócio Atendidas

- [x] Cadastro de usuários (comum e lojista)
- [x] CPF e e-mail únicos
- [x] Lojistas **não podem transferir valores**
- [x] Validação de saldo antes da transferência
- [x] Validação externa (mock API de autorização)
- [x] Notificação simulada por mock API
- [x] Transferência dentro de uma transação (`DB::transaction`)
- [x] API RESTful estruturada

---

## 🧪 Testes Automatizados

- **Testes de Feature**
  - Criação de usuário
  - Transferência com sucesso
  - Falha por saldo insuficiente
  - Falha por lojista tentar pagar
  - Falha por autorização externa negada

- **Testes Unitários**
  - Lógica isolada do `TransactionService`

```bash
php artisan test
# ou rodar um teste específico:
php artisan test --filter=TransferTest
```

---

## 📮 Endpoints Principais

### 🔁 Transferência

**POST** `/api/transfer`

```json
{
  "value": 100.0,
  "payer": 4,
  "payee": 15
}
```

**Respostas Possíveis**:

- `201 Created` – Sucesso na transferência
- `403 Forbidden` – Lojista tentando transferir ou não autorizado externamente
- `422 Unprocessable Entity` – Saldo insuficiente

---

## 🐳 Docker

> Docker totalmente configurado para desenvolvimento e testes.

### Subindo o projeto:

```bash
docker-compose up -d --build
```

### Executando comandos dentro do container:

```bash
docker exec -it transaction-app bash
```

### Executando comandos fora do container:

```bash
docker exec -it transaction-app "comando"
```

---

## 📄 Como Rodar o Projeto

1. Clone o repositório:
```bash
git clone https://github.com/RobersonMariani/Transaction-Project
```

2. Suba o container:
```bash
docker-compose up -d --build
```

3. O docker já roda os comandos essencias para instalar as dependências mas pode ser executado de forma manual dentrou ou fora do container.

Dentro do container:
```bash
docker exec -it transaction-app bash
php artisan migrate --seed
```
Rode os testes:
```bash
php artisan test
```
Fora do container:
```bash
docker exec -it transaction-app php artisan migrate --seed
```
Rode os testes:
```bash
docker exec -it transaction-app php artisan test
```
---

## ✅ Qualidade e CI

- [x] **PHPDoc** para documentação simples
- [x] **PHPStan** nível máximo configurado
- [x] **PHP-CS-Fixer** com padrão de PSR-12
- [x] GitHub Actions rodando análise estática e testes automaticamente
- [x] Código totalmente tipado com PHPDoc e suporte a análise por IDEs

---

## 🛡️ Diferenciais Entregues

- ✅ Código limpo e modularizado
- ✅ Princípios SOLID aplicados
- ✅ Padrões PSR-4 e PSR-12
- ✅ Testes automatizados (unitários + integração)
- ✅ Uso de DTOs, Services e Repositories
- ✅ Docker + CI com análise estática
- ✅ CI com GitHub Actions para testes e análise de código
- ✅ Documentação mínima e clara

---

## 📞 Mock APIs Utilizadas

- **Autorização:**
  `GET https://util.devi.tools/api/v2/authorize`

- **Notificação:**
  `POST https://util.devi.tools/api/v1/notify`

---

## 👨‍💻 Autor

**Roberson Mariani**
Desenvolvedor Fullstack PHP & Laravel | JS e VueJS
[LinkedIn](https://www.linkedin.com/in/roberson-mariani/) | [GitHub](https://github.com/RobersonMariani)
