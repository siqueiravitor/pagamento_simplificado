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
- [x] Criar cliente HTTP para envio de notificação (`POST /notify`)
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

## Ajustes
- [ ] Transferir apenas do usuário logado
- [ ] Ver transferências apenas para casos onde o usuário logado tenha recebido ou feito a transferência
- [ ] Adicionar cadastro de usuários e lojistas
- [ ] Adicionar visualização de saldo do usuário logado
- [ ] Adicionar migration para criação automática do banco de dados

- [ ] Adição de testes automatizados
    Incluir testes unitários e de integração com PHPUnit para validar regras de negócio e melhorar a confiabilidade do sistema.
    Referência: https://phpunit.de/documentation.html
- [ ] Documentação limitada | Adicionar exemplos de requisição
    Considerar ferramentas como Swagger UI ou Laravel Scribe para gerar documentação interativa.
- [ ] Melhorar tratamento de exceções
    Implementar tratamento de exceções mais granular, com códigos de status adequados (400, 404, 422, 500, etc).
    Referência: https://restfulapi.net/http-status-codes/
- [ ] Transação de banco de dados acoplada ao service
    Isolar o controle de transação em uma camada superior ou utilizar um handler para encapsular a execução de blocos transacionais.
- [ ] Controle de saldo sem proteção contra concorrência
    Utilizar SELECT ... FOR UPDATE ou mecanismos de pessimistic/optimistic locking para garantir consistência.
    Referência: https://medium.com/@abhirup.acharya009/managing-concurrent-access-optimistic-locking-vs-pessimistic-locking-0f6a64294db7
- [ ] Notificação acoplada temporalmente à transferência
    Desacoplar esse processo utilizando queues ou event listeners para garantir fluidez e resiliência.
    Referência: https://laravel.com/docs/10.x/queues