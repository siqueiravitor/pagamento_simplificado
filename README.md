## Arquitetura

Este projeto segue uma abordagem baseada em **Domain-Driven Design (DDD)** com princípios de **Clean Architecture**. 
Ele foi dividido em camadas que isolam responsabilidades e promovem organização, testabilidade e desacoplamento.

### Estrutura de Diretórios

```
app/
|
├── Controllers/   # Recebem e tratam requisições HTTP
├── Middleware/    # Middlewares HTTP
├── Routes/        # Definições das rotas
│
src/
│
├── Domain/
│   ├── Entities/          # Entidades de negócio
│   └── Repositories/      # Interfaces contratuais para persistência
│
├── Application/
│   └── Services/          # Casos de uso
│
├── Infrastructure/
│   ├── External/Clients/  # Clientes para APIs externas
│   └── Persistence/       # Implementações dos repositórios
```

## Fluxo de Transferência

1. **POST /transfer** recebe a solicitação JSON.
2. `TransferController` processa o request.
3. O `TransferService` valida usuários, saldo e tipo.
4. O serviço externo de autorização é consultado.
5. Carteiras são debitadas/creditadas.
6. A transação é salva com `TransactionRepository`.

## Integrações Externas

- `https://util.devi.tools/api/v2/authorize` (GET) → autorização da transação

## Tecnologias Utilizadas

- PHP 8.2+
- MySql
- PSR-4 Autoloading
- Arquitetura DDD simplificada
- Design Patterns: Repository, Service Layer
- Integração com APIs externas

## Outras Pastas

- `docs/`: Documentações auxiliares
- `config/`: Configurações
- `public/`: Entrada HTTP (index.php)

## Instalação

```bash
composer dump-autoload
php -S localhost:8000 -t public
```