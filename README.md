# ✅ Estratégia de Testes - Roberson

## 🎯 Visão Geral

Neste projeto, utilizei **testes unitários** e **feature tests (integração)** para garantir a qualidade, confiabilidade e manutenibilidade da aplicação.

---

## ✅ Testes Unitários

- Foco em testar **serviços de forma isolada**, como `UserService`.
- Utilização de **mocks** para interfaces como `UserRepositoryInterface`.
- **Mock do `DB::transaction`** para evitar dependência do banco de dados.
- Aplicação do **princípio da inversão de dependência (DIP)** para tornar o sistema desacoplado e testável.

**Objetivo:** validar se a lógica de negócio funciona corretamente sem dependências externas.

---

## 🌐 Testes de Integração (Feature Tests)

- Simulação de chamadas reais à API, como `POST /users`.
- Validação de todo o fluxo da aplicação:
  - Rota → Request → Controller → Service → Repository → Banco
- Uso de `RefreshDatabase` para garantir isolamento entre os testes.
- Testes positivos e negativos (ex: duplicidade de e-mail ou CPF).

**Objetivo:** garantir que a aplicação funcione corretamente em um cenário real.

---

## 💡 Porque usei os dois

> “Os testes unitários garantem robustez da lógica de negócio, enquanto os feature tests garantem que a aplicação funcione de ponta a ponta em um cenário real.”

---

Roberson Mariani
Desenvolvedor Fullstack | Laravel • Vue.js • PHP • Docker • SQL
