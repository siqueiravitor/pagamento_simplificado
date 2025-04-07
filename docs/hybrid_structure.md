# Estrutura híbrida: Integração de Microframework com DDD

## Por que manter `app/` e `src/`?

O projeto adota uma **estrutura híbrida**, sendo um MVC leve (baseado no Laravel) com os princípios modernos de arquitetura (DDD + Clean Architecture).

---

app/
├── Controllers/   ← Entrada HTTP
├── Core/          ← Infra geral (Router, Session, DB)
└── Views/         ← Renderização HTML
src/
├── Domain/        ← Entidades + regras
├── Application/   ← Casos de uso
└── Infrastructure/← Implementações reais (MySQL, HTTP, etc)


## app/ — Entrada, Fluxo HTTP e Views 

A pasta `app/` abriga:

- `Controllers/`: Recebem as requisições HTTP, acionam os serviços de aplicação.
- `Core/`: Componentes essenciais do microframework (rotas, sessão, response, etc).
- `Views/`: Renderização de HTML.

---

## src/ — Regra de Negócio

A pasta `src/` é estruturada com base no Domain-Driven Design (DDD), dividida em:

- `Domain/`: Entidades e interfaces.
- `Application/`: Serviços que orquestram regras e casos de uso.
- `Infrastructure/`: Implementações concretas.

---

## Como elas se integram?

1. O `Controller` dentro de `app/` é responsável por orquestrar a entrada HTTP.
2. Ele chama um `Service` de `src/Application/Services`.
3. O serviço usa um `Repository` de `src/Domain`, implementado em `src/Infrastructure`.

Essa separação permite:
- Evoluir a regra de negócio sem mexer na camada de entrada.
- Mudar o banco de dados sem alterar regras.
- Testar serviços isoladamente.

