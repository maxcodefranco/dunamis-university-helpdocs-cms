#!/bin/bash

# Deploy manual para Hostgator via SSH
# Uso: ./scripts/deploy-hostgator.sh

set -e

echo "🚀 Deploy Manual para Hostgator"
echo "================================"

# Verificar se as variáveis de ambiente estão configuradas
if [ -z "$HOSTGATOR_HOST" ] || [ -z "$HOSTGATOR_USER" ] || [ -z "$HOSTGATOR_PATH" ]; then
    echo "❌ Erro: Variáveis de ambiente não configuradas"
    echo ""
    echo "Configure as seguintes variáveis:"
    echo "  export HOSTGATOR_HOST='seu-dominio.com'"
    echo "  export HOSTGATOR_USER='seu-usuario'"
    echo "  export HOSTGATOR_PATH='/home/usuario/public_html'"
    echo "  export HOSTGATOR_PORT='22'  # Opcional, padrão: 22"
    echo ""
    echo "Ou crie um arquivo .env.hostgator:"
    echo "  HOSTGATOR_HOST=seu-dominio.com"
    echo "  HOSTGATOR_USER=seu-usuario"
    echo "  HOSTGATOR_PATH=/home/usuario/public_html"
    echo "  HOSTGATOR_PORT=22"
    exit 1
fi

# Usar porta padrão se não especificada
HOSTGATOR_PORT=${HOSTGATOR_PORT:-22}

echo "📋 Configuração:"
echo "  Host: $HOSTGATOR_HOST"
echo "  User: $HOSTGATOR_USER"
echo "  Path: $HOSTGATOR_PATH"
echo "  Port: $HOSTGATOR_PORT"
echo ""

# Confirmar deploy
read -p "Deseja continuar com o deploy? (s/n) " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Ss]$ ]]; then
    echo "❌ Deploy cancelado"
    exit 1
fi

# Fazer backup antes de deploy
echo "📦 Criando backup no servidor..."
ssh -p $HOSTGATOR_PORT $HOSTGATOR_USER@$HOSTGATOR_HOST "
    if [ -d '$HOSTGATOR_PATH' ]; then
        BACKUP_DIR=\"$HOSTGATOR_PATH-backup-\$(date +%Y%m%d_%H%M%S)\"
        cp -r $HOSTGATOR_PATH \$BACKUP_DIR
        echo \"✅ Backup criado: \$BACKUP_DIR\"
    fi
"

# Sync arquivos usando rsync
echo "📤 Sincronizando arquivos..."
rsync -avz --delete \
    --exclude='.git' \
    --exclude='.github' \
    --exclude='node_modules' \
    --exclude='docker-compose.yml' \
    --exclude='.env' \
    --exclude='.env.example' \
    --exclude='.dockerignore' \
    --exclude='docs/' \
    --exclude='scripts/' \
    --exclude='.claude/' \
    --exclude='wp-content/uploads/' \
    --exclude='wp-content/cache/' \
    -e "ssh -p $HOSTGATOR_PORT" \
    ./ $HOSTGATOR_USER@$HOSTGATOR_HOST:$HOSTGATOR_PATH/

# Ajustar permissões no servidor
echo "🔐 Ajustando permissões..."
ssh -p $HOSTGATOR_PORT $HOSTGATOR_USER@$HOSTGATOR_HOST "
    cd $HOSTGATOR_PATH
    find . -type d -exec chmod 755 {} \;
    find . -type f -exec chmod 644 {} \;
    chmod 755 wp-content
    chmod -R 755 wp-content/themes
    chmod -R 755 wp-content/plugins
    chmod -R 777 wp-content/uploads
    echo '✅ Permissões atualizadas'
"

echo ""
echo "✅ Deploy concluído com sucesso!"
echo "🌐 Acesse: http://$HOSTGATOR_HOST"
