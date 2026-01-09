# Deploy WordPress no Railway

Este guia mostra como fazer deploy do WordPress customizado no Railway usando CLI.

## Pré-requisitos

1. Conta no Railway (https://railway.app)
2. Railway CLI instalado (`npm i -g @railway/cli`)
3. Git configurado

## Estrutura do Projeto

```
project: genesiz-studio
├── service: university-dunamis-helpdocs-cms (WordPress)
├── database: university-dunamis-helpdocs-db (MySQL)
└── volume: wp-content-storage (persistência de uploads)
```

## Passo a Passo

### 1. Instalar Railway CLI (se necessário)

```bash
npm install -g @railway/cli
```

### 2. Login no Railway

```bash
railway login
```

### 3. Criar/Conectar ao Projeto

```bash
# Se o projeto genesiz-studio já existe
railway link

# Ou criar novo projeto
railway init
```

### 4. Criar o Banco de Dados MySQL

```bash
# Adicionar plugin MySQL ao projeto
railway add --database mysql

# Renomear o serviço para university-dunamis-helpdocs-db
# (fazer via dashboard do Railway)
```

### 5. Configurar Variáveis de Ambiente

No dashboard do Railway, configurar para o serviço WordPress:

```env
# Database (vem automaticamente do MySQL plugin)
WORDPRESS_DB_HOST=${{MySQL.MYSQLHOST}}:${{MySQL.MYSQLPORT}}
WORDPRESS_DB_NAME=${{MySQL.MYSQLDATABASE}}
WORDPRESS_DB_USER=${{MySQL.MYSQLUSER}}
WORDPRESS_DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}

# WordPress Settings
WORDPRESS_TABLE_PREFIX=wp_
WORDPRESS_DEBUG=0

# Security Keys (gerar em: https://api.wordpress.org/secret-key/1.1/salt/)
WORDPRESS_CONFIG_EXTRA=
define('AUTH_KEY',         'seu-auth-key-aqui');
define('SECURE_AUTH_KEY',  'seu-secure-auth-key-aqui');
define('LOGGED_IN_KEY',    'seu-logged-in-key-aqui');
define('NONCE_KEY',        'seu-nonce-key-aqui');
define('AUTH_SALT',        'seu-auth-salt-aqui');
define('SECURE_AUTH_SALT', 'seu-secure-auth-salt-aqui');
define('LOGGED_IN_SALT',   'seu-logged-in-salt-aqui');
define('NONCE_SALT',       'seu-nonce-salt-aqui');
```

### 6. Criar Volume para Uploads

```bash
# Via CLI
railway volume create --name wp-content-storage --mount /var/www/html/wp-content/uploads

# Ou via dashboard do Railway:
# - Service Settings > Volumes > New Volume
# - Name: wp-content-storage
# - Mount Path: /var/www/html/wp-content/uploads
```

### 7. Deploy

```bash
# Fazer commit das mudanças
git add .
git commit -m "Initial WordPress setup for Railway"

# Push para GitHub
git push -u origin main

# Deploy no Railway
railway up
```

### 8. Verificar Deploy

```bash
# Ver logs
railway logs

# Abrir aplicação
railway open
```

## Comandos Úteis

```bash
# Ver status dos serviços
railway status

# Abrir dashboard do projeto
railway open

# Ver logs em tempo real
railway logs --follow

# Conectar ao banco de dados
railway connect mysql

# Executar comando no container
railway run [comando]

# Ver variáveis de ambiente
railway variables

# Adicionar variável de ambiente
railway variables set KEY=value
```

## Estrutura de Arquivos

- `Dockerfile` - Configuração do container WordPress
- `railway.toml` - Configuração específica do Railway
- `.dockerignore` - Arquivos ignorados no build
- `wp-content/` - Tema e plugins customizados

## Troubleshooting

### Build Falha

```bash
# Ver logs detalhados do build
railway logs --build
```

### Banco de Dados não Conecta

1. Verificar variáveis de ambiente no dashboard
2. Confirmar que o plugin MySQL está instalado
3. Verificar network interno do Railway

### Uploads não Persistem

1. Verificar se o volume está criado e montado corretamente
2. Path deve ser: `/var/www/html/wp-content/uploads`
3. Verificar permissões (container usa usuário www-data)

### Site Lento ou Timeout

1. Aumentar memória do serviço no dashboard
2. Verificar health check configurado
3. Considerar usar CDN para assets estáticos

## Backup

### Banco de Dados

```bash
# Conectar ao MySQL e fazer dump
railway connect mysql
mysqldump -u $MYSQLUSER -p $MYSQLDATABASE > backup.sql
```

### Arquivos (Uploads)

Use o dashboard do Railway para fazer snapshot do volume.

## Produção

Para ambiente de produção:

1. Configurar domínio customizado no Railway
2. Habilitar SSL (automático no Railway)
3. Configurar `WORDPRESS_DEBUG=0`
4. Implementar cache (Redis/CloudFlare)
5. Configurar CDN para assets
6. Backups automáticos do banco e volume

## Monitoramento

O Railway oferece:
- Métricas de CPU e memória
- Logs em tempo real
- Health checks automáticos
- Alertas de deploy

## Custos

Railway cobra por:
- Recursos computacionais (CPU/RAM)
- Armazenamento (volume para uploads)
- Transferência de dados

Plano gratuito: $5 de crédito/mês
Plano Developer: $5/mês + uso

## Suporte

- Railway Docs: https://docs.railway.app
- Railway Discord: https://discord.gg/railway
- GitHub Issues: https://github.com/maxcodefranco/dunamis-university-helpdocs-cms/issues
