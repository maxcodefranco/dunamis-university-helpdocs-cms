# 🚀 Deploy WordPress no Hostgator

Guia completo para deploy do WordPress customizado no Hostgator via SSH.

## 📋 Pré-requisitos

1. **Conta Hostgator** com acesso SSH habilitado
2. **SSH Key** configurada para acesso sem senha
3. **Git** instalado localmente
4. **rsync** instalado (vem por padrão no Linux/Mac)

## 🔑 Configurar Acesso SSH

### 1. Gerar SSH Key (se não tiver)

```bash
ssh-keygen -t ed25519 -C "seu-email@dominio.com"
# Pressione Enter para aceitar o caminho padrão
# Digite uma senha segura (ou deixe vazio)
```

### 2. Copiar SSH Key para Hostgator

```bash
ssh-copy-id -p 22 usuario@seu-dominio.com
# Ou manualmente:
cat ~/.ssh/id_ed25519.pub
# Copie e adicione em: cPanel > SSH Access > Manage SSH Keys
```

### 3. Testar Conexão

```bash
ssh -p 22 usuario@seu-dominio.com
# Deve conectar sem pedir senha
```

## 🚀 Opção 1: Deploy Automático (GitHub Actions)

### Configurar GitHub Secrets

1. Acesse: https://github.com/maxcodefranco/dunamis-university-helpdocs-cms/settings/secrets/actions

2. Adicione os seguintes secrets:

| Secret | Valor | Exemplo |
|--------|-------|---------|
| `SSH_PRIVATE_KEY` | Conteúdo de `~/.ssh/id_ed25519` | `-----BEGIN OPENSSH PRIVATE KEY-----...` |
| `REMOTE_HOST` | Domínio do Hostgator | `helpdocs.dunamis.com` |
| `REMOTE_USER` | Usuário SSH | `dunamis` |
| `REMOTE_PORT` | Porta SSH (padrão: 22) | `22` |
| `REMOTE_PATH` | Caminho no servidor | `/home/dunamis/public_html` |

### Como Obter SSH_PRIVATE_KEY

```bash
# No seu computador:
cat ~/.ssh/id_ed25519
# Copie TUDO, incluindo:
# -----BEGIN OPENSSH PRIVATE KEY-----
# ...
# -----END OPENSSH PRIVATE KEY-----
```

### Testar GitHub Actions

1. Faça uma mudança no código:
   ```bash
   echo "# Test" >> README.md
   git add README.md
   git commit -m "test: GitHub Actions deploy"
   git push origin main
   ```

2. Veja o deploy em: https://github.com/maxcodefranco/dunamis-university-helpdocs-cms/actions

3. Após sucesso, verifique o site

## 🔧 Opção 2: Deploy Manual via Script

### 1. Configurar Variáveis de Ambiente

Crie arquivo `.env.hostgator` na raiz do projeto:

```bash
HOSTGATOR_HOST=helpdocs.dunamis.com
HOSTGATOR_USER=dunamis
HOSTGATOR_PATH=/home/dunamis/public_html
HOSTGATOR_PORT=22
```

Ou exporte as variáveis:

```bash
export HOSTGATOR_HOST='helpdocs.dunamis.com'
export HOSTGATOR_USER='dunamis'
export HOSTGATOR_PATH='/home/dunamis/public_html'
export HOSTGATOR_PORT='22'
```

### 2. Executar Script de Deploy

```bash
chmod +x scripts/deploy-hostgator.sh
./scripts/deploy-hostgator.sh
```

O script irá:
- ✅ Criar backup automático no servidor
- ✅ Sincronizar arquivos via rsync
- ✅ Ajustar permissões automaticamente
- ✅ Excluir arquivos desnecessários (.git, docs, etc)

## 📁 Estrutura de Arquivos Deployados

```
/home/usuario/public_html/
├── wp-content/
│   ├── themes/
│   │   └── helpdocs/          ← Tema customizado
│   ├── plugins/
│   ├── uploads/                ← Preservado (não sobrescrito)
│   └── languages/
├── .htaccess
└── (arquivos core do WordPress)
```

## ⚙️ Primeira Instalação no Hostgator

### 1. Preparar Servidor

```bash
# Conectar via SSH
ssh -p 22 usuario@seu-dominio.com

# Criar diretório se não existir
mkdir -p ~/public_html

# Verificar permissões
ls -la ~/public_html
```

### 2. Instalar WordPress Core no Servidor

**Opção A: Via cPanel**
1. cPanel > Softaculous > WordPress
2. Instalar na pasta `public_html`

**Opção B: Via SSH (Download direto)**
```bash
ssh -p 22 usuario@seu-dominio.com

cd ~/public_html

# Download WordPress
wget https://wordpress.org/latest.tar.gz
tar -xzf latest.tar.gz
mv wordpress/* ./
rm -rf wordpress latest.tar.gz

# Criar wp-config.php
cp wp-config-sample.php wp-config.php
nano wp-config.php
# Configure DB_NAME, DB_USER, DB_PASSWORD, DB_HOST
```

### 3. Fazer Primeiro Deploy

```bash
# No seu computador:
./scripts/deploy-hostgator.sh
```

### 4. Finalizar Instalação

1. Acesse: `http://seu-dominio.com`
2. Complete instalação do WordPress
3. Login em `/wp-admin`
4. Ativar tema **HelpDocs**
5. Configurar permalinks: **Nome do post**

## 🔄 Fluxo de Deploy Contínuo

### Workflow Diário

```bash
# 1. Fazer mudanças locais
git add .
git commit -m "feat: nova funcionalidade"

# 2. Push para GitHub
git push origin main

# 3. GitHub Actions faz deploy automaticamente! 🎉

# 4. Verificar em ~2 minutos:
#    https://helpdocs.dunamis.com
```

## 🛡️ Segurança e Permissões

### Permissões Corretas

```bash
# Arquivos: 644 (rw-r--r--)
# Diretórios: 755 (rwxr-xr-x)
# wp-content/uploads: 777 (rwxrwxrwx)

# Comando para corrigir:
find ~/public_html -type d -exec chmod 755 {} \;
find ~/public_html -type f -exec chmod 644 {} \;
chmod -R 777 ~/public_html/wp-content/uploads
```

### Arquivos .htaccess

O `.htaccess` é preservado no deploy. Não é sobrescrito.

## 📦 Backup Automático

Cada deploy cria backup automático:

```bash
# Backups ficam em:
/home/usuario/public_html-backup-YYYYMMDD_HHMMSS/

# Restaurar backup:
ssh usuario@dominio.com
cd ~
rm -rf public_html
mv public_html-backup-20260109_123456 public_html
```

## 🔍 Troubleshooting

### Erro: Permission denied (publickey)

**Problema:** SSH key não configurada

**Solução:**
```bash
ssh-copy-id -p 22 usuario@seu-dominio.com
```

### Erro: Connection refused

**Problema:** SSH não habilitado no Hostgator

**Solução:**
1. cPanel > SSH Access
2. Enable SSH Access
3. Generate/Import Key

### Deploy não atualiza arquivos

**Problema:** Rsync não está sincronizando

**Solução:**
```bash
# Forçar deploy completo
./scripts/deploy-hostgator.sh
# Use --delete flag (já incluído no script)
```

### Tema não aparece

**Problema:** Arquivos não foram copiados corretamente

**Solução:**
```bash
# Verificar no servidor:
ssh usuario@dominio.com
ls -la ~/public_html/wp-content/themes/helpdocs

# Se não existir, deploy novamente
```

## 📊 Monitoramento

### Verificar Deploy via SSH

```bash
ssh usuario@dominio.com

# Ver últimas modificações
ls -lt ~/public_html | head -10

# Ver logs do Apache
tail -f ~/public_html/error_log

# Ver tamanho dos arquivos
du -sh ~/public_html/wp-content/*
```

## 🌐 Domínio Customizado

### Configurar no Hostgator

1. cPanel > Domains > Add Domain
2. Adicionar: `helpdocs.dunamis.com`
3. Document Root: `/home/usuario/public_html`

### Atualizar WordPress

```bash
# No wp-admin:
# Configurações > Geral
# URL do WordPress: https://helpdocs.dunamis.com
# URL do Site: https://helpdocs.dunamis.com
```

## ✅ Checklist Pós-Deploy

- [ ] Site acessível via navegador
- [ ] Tema HelpDocs ativo
- [ ] Permalinks configurados
- [ ] Upload de imagem funciona
- [ ] SSL/HTTPS funcionando
- [ ] Backup automático configurado
- [ ] GitHub Actions testado

## 📞 Suporte

- **Hostgator Support**: https://www.hostgator.com/support
- **GitHub Issues**: https://github.com/maxcodefranco/dunamis-university-helpdocs-cms/issues
- **WordPress Forums**: https://wordpress.org/support/

---

**Última atualização:** 2026-01-09
**Repositório:** https://github.com/maxcodefranco/dunamis-university-helpdocs-cms
