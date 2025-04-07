## Estrutura Inicial
- [x] Organização baseada em DDD + Clean Architecture
- [x] Camadas separadas: Domain, Application, Infrastructure
- [x] Autoload PSR-4
- [x] Entidades
- [x] Interfaces dos repositórios
- [x] Implementações dos repositórios
- [x] Serviço de transferência (`TransferService`)
- [x] Controller de transferência (`TransferController`)
- [x] Documentação técnica

## Regras de Negócio e Integrações
- [x] Criar estrutura de rotas e vincular `/transfer`
- [ ] Tratamentos MySQL
- [x] Criar cliente HTTP para autorização externa (`GET /authorize`)
- [ ] Criar cliente HTTP para envio de notificação (`POST /notify`)
- [x] Validar se o `payee` e `payer` existem e têm permissões corretas
- [x] Impedir transferências do tipo "payer == payee"
- [x] Verificar saldo disponível antes de transferir

## Segurança e Qualidade
- [x] Padronização de respostas HTTP (JSON estruturado para erro/sucesso)
- [ ] Middleware de autenticação (token simples ou JWT)
- [x] Tratamento de exceções global (HTTP error handler)
- [x] Middleware de logging de requisições
- [x] Logs para falhas de integração externa (notify/authorize)

## Adicionais
- [ ] Testes de unidade (Wallet, TransferService, regras)
- [ ] Testes de integração (end-to-end `/transfer`)
- [ ] Docker: `Dockerfile` + `docker-compose.yml` (PHP + MySQL)
- [ ] Retry ou fallback para falha de notificação externa