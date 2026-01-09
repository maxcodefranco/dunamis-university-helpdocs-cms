# 📋 Resumo da Migração: Railway → Hostgator

**Data:** 2026-01-09
**Status:** ✅ Concluída

## 🎯 O que foi feito

### ❌ Removido
- Railway configuration (Dockerfile, railway.toml, .railway)
- Railway deployment scripts (deploy-to-railway.py, etc)
- Railway documentation (movida para `docs/archive/`)

### ✅ Adicionado
- **GitHub Actions Workflow** (`.github/workflows/deploy-hostgator.yml`)
  - Deploy automático a cada push na branch `main`
  - SSH deployment via rsync
  - Backup automático antes de deploy
  - Ajuste automático de permissões

- **Script de Deploy Manual** (`scripts/deploy-hostgator.sh`)
  - Deploy via SSH com rsync
  - Backup automático
  - Configuração via `.env.hostgator`

- **Documentação Completa** (`docs/DEPLOY-HOSTGATOR.md`)
  - Guia passo a passo
  - Configuração de SSH keys
  - Troubleshooting
  - Checklist pós-deploy

- **Exemplo de Configuração** (`.env.hostgator.example`)
  - Template para credenciais Hostgator

### 📝 Atualizado
- `README.md` - Reflete novo método de deploy
- `.gitignore` - Ignora `.env.hostgator`

## 🚀 Próximos Passos

### 1. Configurar GitHub Secrets (Deploy Automático)

Acesse: https://github.com/maxcodefranco/dunamis-university-helpdocs-cms/settings/secrets/actions

Adicione:
- `SSH_PRIVATE_KEY` - Sua chave SSH privada
- `REMOTE_HOST` - Domínio do Hostgator
- `REMOTE_USER` - Usuário SSH
- `REMOTE_PORT` - Porta SSH (22)
- `REMOTE_PATH` - Caminho no servidor (`/home/usuario/public_html`)

**Como obter SSH_PRIVATE_KEY:**
```bash
cat ~/.ssh/id_ed25519
# ou
cat ~/.ssh/id_rsa
# Copie TUDO, incluindo -----BEGIN e -----END
```

### 2. Ou Configure Deploy Manual

```bash
# Copiar template
cp .env.hostgator.example .env.hostgator

# Editar com suas credenciais
nano .env.hostgator

# Executar deploy
./scripts/deploy-hostgator.sh
```

### 3. Primeira Instalação no Hostgator

**Se WordPress ainda não está instalado no servidor:**

```bash
# Via cPanel:
# 1. Softaculous Apps Installer > WordPress
# 2. Instalar em public_html
# 3. Configurar banco de dados

# Ou via SSH:
ssh usuario@dominio.com
cd ~/public_html
wget https://wordpress.org/latest.tar.gz
tar -xzf latest.tar.gz
mv wordpress/* ./
rm -rf wordpress latest.tar.gz
```

### 4. Deploy e Ativação

```bash
# Deploy dos arquivos (tema customizado)
./scripts/deploy-hostgator.sh

# Ou apenas push (se GitHub Actions configurado)
git push origin main
```

### 5. Finalizar no WordPress

1. Acesse: `http://seu-dominio.com`
2. Complete instalação (se primeira vez)
3. Login `/wp-admin`
4. **Aparência > Temas** > Ativar **HelpDocs**
5. **Configurações > Links Permanentes** > **Nome do post**

## 📊 Comparação

| Aspecto | Railway | Hostgator |
|---------|---------|-----------|
| **Deploy** | Docker container | SSH + rsync |
| **Automação** | ✅ CI/CD | ✅ GitHub Actions |
| **Custo** | ~$15-20/mês | Incluso no plano |
| **Complexidade** | ⚠️ Alta | ✅ Simples |
| **Volumes** | ⚠️ Problemático | ✅ Nativo |
| **Uploads** | Precisa Cloudinary | ✅ Persistem |
| **Velocidade Deploy** | ⚠️ 3-5 min | ✅ 30-60 seg |
| **Controle** | ⚠️ Limitado | ✅ Total |

## ✅ Vantagens da Migração

1. **Deploy mais rápido** (30-60s vs 3-5 min)
2. **Sem problemas de volume** (uploads persistem naturalmente)
3. **Custo reduzido** (incluso no plano Hostgator)
4. **Controle total** via SSH
5. **Backup automático** em cada deploy
6. **Compatibilidade 100%** com WordPress

## 📖 Documentação

- **Principal:** [docs/DEPLOY-HOSTGATOR.md](docs/DEPLOY-HOSTGATOR.md)
- **GitHub Actions:** [.github/workflows/deploy-hostgator.yml](.github/workflows/deploy-hostgator.yml)
- **Script Manual:** [scripts/deploy-hostgator.sh](scripts/deploy-hostgator.sh)
- **Dev Local:** [docs/QUICKSTART.md](docs/QUICKSTART.md)

## 🗄️ Arquivo Railway

Toda documentação Railway foi movida para `docs/archive/` para referência futura.

## 🆘 Suporte

Se precisar de ajuda:
1. Consulte: `docs/DEPLOY-HOSTGATOR.md`
2. Abra issue: https://github.com/maxcodefranco/dunamis-university-helpdocs-cms/issues
3. Contato Hostgator: https://www.hostgator.com/support

---

**Status:** ✅ Projeto pronto para deploy no Hostgator
**Próxima ação:** Configurar GitHub Secrets ou `.env.hostgator`
