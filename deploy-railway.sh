#!/bin/bash

# Deploy script for Railway
# Este script automatiza o deploy do WordPress no Railway

set -e

echo "🚀 Deploy WordPress para Railway - Projeto genesiz-studio"
echo "=========================================================="

# Cores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Verificar se Railway CLI está instalado
if ! command -v railway &> /dev/null; then
    echo -e "${RED}❌ Railway CLI não está instalado${NC}"
    echo "Instale com: npm install -g @railway/cli"
    exit 1
fi

echo -e "${GREEN}✓${NC} Railway CLI instalado"

# Verificar se está logado
if ! railway whoami &> /dev/null; then
    echo -e "${YELLOW}⚠${NC} Você não está logado no Railway"
    echo "Fazendo login..."
    railway login
fi

RAILWAY_USER=$(railway whoami)
echo -e "${GREEN}✓${NC} Logado como: $RAILWAY_USER"

# Verificar se tem mudanças não commitadas
if [[ -n $(git status -s) ]]; then
    echo -e "${YELLOW}⚠${NC} Você tem mudanças não commitadas"
    echo "Commitando mudanças..."
    git add .
    git commit -m "chore: deploy updates" || true
    git push origin main
fi

echo -e "${GREEN}✓${NC} Git sincronizado"

echo ""
echo "📋 Próximos passos manuais:"
echo "=========================="
echo ""
echo "1. Acesse: https://railway.app/dashboard"
echo "2. Abra o projeto: genesiz-studio"
echo ""
echo "3. Criar banco de dados MySQL:"
echo "   - Clique em 'New' > 'Database' > 'Add MySQL'"
echo "   - Renomeie o serviço para: university-dunamis-helpdocs-db"
echo ""
echo "4. Criar serviço WordPress:"
echo "   - Clique em 'New' > 'GitHub Repo'"
echo "   - Selecione: maxcodefranco/dunamis-university-helpdocs-cms"
echo "   - Renomeie o serviço para: university-dunamis-helpdocs-cms"
echo ""
echo "5. Configurar variáveis de ambiente no serviço WordPress:"
echo "   WORDPRESS_DB_HOST=\${{MySQL.MYSQLHOST}}:\${{MySQL.MYSQLPORT}}"
echo "   WORDPRESS_DB_NAME=\${{MySQL.MYSQLDATABASE}}"
echo "   WORDPRESS_DB_USER=\${{MySQL.MYSQLUSER}}"
echo "   WORDPRESS_DB_PASSWORD=\${{MySQL.MYSQLPASSWORD}}"
echo "   WORDPRESS_TABLE_PREFIX=wp_"
echo "   WORDPRESS_DEBUG=0"
echo ""
echo "6. Adicionar volume para uploads:"
echo "   - No serviço WordPress, vá em 'Settings' > 'Volumes'"
echo "   - Clique em 'New Volume'"
echo "   - Nome: wp-content-storage"
echo "   - Mount Path: /var/www/html/wp-content/uploads"
echo ""
echo "7. Deploy automático será iniciado após conectar o repo"
echo ""
echo "8. Gerar WordPress Security Keys:"
echo "   - Acesse: https://api.wordpress.org/secret-key/1.1/salt/"
echo "   - Adicione os keys em WORDPRESS_CONFIG_EXTRA"
echo ""
echo -e "${GREEN}✓${NC} Repositório pronto para deploy!"
echo ""
echo "📖 Documentação completa: RAILWAY.md"
