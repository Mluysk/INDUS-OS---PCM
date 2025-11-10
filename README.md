# INDUS OS – PCM Profissional

Aplicação PHP completa para gestão de Planejamento e Controle de Manutenção (PCM). O sistema centraliza o cadastro de ativos industriais, planos preventivos, ordens de serviço, equipe técnica e checklists operacionais, oferecendo uma visão moderna e responsiva para times de manutenção.

## Recursos principais

- **Autenticação segura** com usuário administrador padrão (`admin@pcm.local` / `pcm123`).
- **Dashboard executivo** com indicadores chave, últimas ordens de serviço e distribuição por status.
- **Gestão de ativos e equipamentos** com dados de criticidade, fabricante, localização e observações.
- **Planos de manutenção** com frequência, tempo estimado, ferramentas e notas de segurança.
- **Ordens de serviço completas** (corretivas/preventivas) com controle de status, prioridade, responsáveis, datas e feedback.
- **Equipe técnica** com contatos e especialidades para facilitar a alocação de mão de obra.
- **Checklists operacionais** integrados às ordens, permitindo registrar passo a passo e marcar conclusão.
- **Proteções CSRF e hashing de senha** para maior segurança.
- **Banco de dados SQLite** embarcado, sem dependências adicionais.

## Estrutura

```
public/             # Entrypoints acessados pelo servidor web
├── index.php       # Dashboard
├── login.php       # Tela de autenticação
├── equipment.php   # CRUD de equipamentos
├── plans.php       # CRUD de planos de manutenção
├── work_orders.php # CRUD de ordens de serviço e checklists
└── technicians.php # CRUD de técnicos

templates/          # Layouts e views (Bootstrap 5)
config.php          # Configurações da aplicação
helpers.php         # Funções utilitárias e helpers de sessão/CSRF
pcm_service.php     # Camada de acesso a dados e regras de negócio
database.php        # Conexão SQLite e criação de schema
index.php, login.php, etc. (raiz) # Encaminham para os entrypoints em public/
```

## Como executar

1. **Requisitos**: PHP 8.1+ com extensão `pdo_sqlite` habilitada.
2. Instale as dependências (nenhuma adicional necessária).
3. Execute o servidor embutido do PHP apontando para a pasta `public/`:

   ```bash
   php -S localhost:8080 -t public
   ```

   Caso utilize um ambiente como XAMPP/WAMP que aponta diretamente para a raiz do projeto, basta acessar `http://localhost/INDUS-OS---PCM/login.php`. A aplicação detecta automaticamente se está na raiz ou em uma subpasta (por exemplo, `http://localhost/sistemas/pcm/login.php`), mantendo todos os links e redirecionamentos funcionando. Os arquivos na raiz continuam encaminhando para os scripts de `public/` quando necessário.

4. Acesse `http://localhost:8080` e faça login com:
   - Usuário: `admin@pcm.local`
   - Senha: `pcm123`

   Altere a senha diretamente na base ou implemente lógica adicional conforme a necessidade do projeto.

O arquivo `data/pcm.sqlite` será criado automaticamente na primeira execução com todas as tabelas exigidas.

## Personalização

- Ajuste `config.php` para alterar o nome do sistema ou o caminho do banco.
- Adicione camadas extras (por exemplo, upload de documentos, relatórios) utilizando os helpers e serviços existentes como base.
- Utilize o Bootstrap 5.3 já incluído nas views para manter o visual consistente.

## Licença

Projeto disponibilizado para uso interno/educacional. Avalie e ajuste conforme as diretrizes da sua organização.
