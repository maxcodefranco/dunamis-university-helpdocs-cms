#!/bin/bash

# Script para configurar Railway via CLI
# Projeto: genesiz-studio (bd388c2c-16bd-418f-90cb-d68d01e2fb16)

set -e

PROJECT_ID="bd388c2c-16bd-418f-90cb-d68d01e2fb16"
MYSQL_SERVICE="university-dunamis-helpdocs-db"
WP_SERVICE="university-dunamis-helpdocs-cms"
GITHUB_REPO="maxcodefranco/dunamis-university-helpdocs-cms"

echo "🚀 Configurando Railway para Dunamis University HelpDocs"
echo "=========================================================="

# Verificar se Railway CLI está instalado
if ! command -v railway &> /dev/null; then
    echo "❌ Railway CLI não está instalado"
    exit 1
fi

# Verificar se está no diretório correto
if [ ! -f "Dockerfile" ]; then
    echo "❌ Dockerfile não encontrado. Execute este script no diretório do projeto."
    exit 1
fi

echo "✅ Projeto linkado: genesiz-studio"
echo ""
echo "⚠️  Comandos interativos não podem ser automatizados via CLI não-TTY"
echo ""
echo "🔧 Passos manuais necessários:"
echo ""
echo "1. Adicionar MySQL Database:"
echo "   Acesse: https://railway.app/project/$PROJECT_ID"
echo "   Clique em '+ New' > 'Database' > 'Add MySQL'"
echo "   Renomeie para: $MYSQL_SERVICE"
echo ""
echo "2. Adicionar WordPress Service:"
echo "   Clique em '+ New' > 'GitHub Repo'"
echo "   Selecione: $GITHUB_REPO"
echo "   Renomeie para: $WP_SERVICE"
echo ""
echo "3. Configurar variáveis (copie e cole no Railway Dashboard):"
echo ""
echo "   WORDPRESS_DB_HOST=\${{MySQL.MYSQLHOST}}:\${{MySQL.MYSQLPORT}}"
echo "   WORDPRESS_DB_NAME=\${{MySQL.MYSQLDATABASE}}"
echo "   WORDPRESS_DB_USER=\${{MySQL.MYSQLUSER}}"
echo "   WORDPRESS_DB_PASSWORD=\${{MySQL.MYSQLPASSWORD}}"
echo "   WORDPRESS_TABLE_PREFIX=wp_"
echo "   WORDPRESS_DEBUG=0"
echo ""
echo "4. Gerar Security Keys:"
echo "   Acesse: https://api.wordpress.org/secret-key/1.1/salt/"
echo "   Adicione o output em WORDPRESS_CONFIG_EXTRA"
echo ""
echo "5. Adicionar Volume:"
echo "   No serviço WordPress: Settings > Volumes > New Volume"
echo "   Name: wp-content-storage"
echo "   Mount Path: /var/www/html/wp-content/uploads"
echo ""
echo "📖 Documentação completa: DEPLOY-QUICKSTART.md"
echo ""
echo "🌐 Abrir dashboard do projeto:"
echo "   https://railway.app/project/$PROJECT_ID"
