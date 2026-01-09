#!/bin/bash

# Script para gerar WordPress Security Keys
# e preparar WORDPRESS_CONFIG_EXTRA para Railway

echo "🔐 Gerando WordPress Security Keys"
echo "===================================="
echo ""

# Gerar keys usando API do WordPress
echo "📡 Baixando keys da API do WordPress..."
KEYS=$(curl -s https://api.wordpress.org/secret-key/1.1/salt/)

if [ -z "$KEYS" ]; then
    echo "❌ Erro ao gerar keys. Verifique sua conexão com a internet."
    echo ""
    echo "Tente manualmente: https://api.wordpress.org/secret-key/1.1/salt/"
    exit 1
fi

echo "✅ Keys geradas com sucesso!"
echo ""
echo "════════════════════════════════════════════════════════════════"
echo "WORDPRESS_CONFIG_EXTRA - Copie TUDO abaixo"
echo "════════════════════════════════════════════════════════════════"
echo ""

# Exibir as keys geradas
echo "$KEYS"

# Adicionar configurações extras
cat << 'EOF'

/* Force HTTPS */
define('FORCE_SSL_ADMIN', true);
if (strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false) {
    $_SERVER['HTTPS'] = 'on';
}

/* Memory Limits */
define('WP_MEMORY_LIMIT', '256M');
define('WP_MAX_MEMORY_LIMIT', '512M');

/* Security */
define('DISALLOW_FILE_EDIT', true);

/* Performance */
define('WP_POST_REVISIONS', 5);
define('AUTOSAVE_INTERVAL', 300);
define('EMPTY_TRASH_DAYS', 30);
EOF

echo ""
echo "════════════════════════════════════════════════════════════════"
echo ""
echo "📋 COMO ADICIONAR NO RAILWAY:"
echo ""
echo "1. Acesse: https://railway.app/project/bd388c2c-16bd-418f-90cb-d68d01e2fb16"
echo "2. Clique no serviço: university-dunamis-helpdocs-cms"
echo "3. Vá na aba 'Variables'"
echo "4. Clique '+ New Variable'"
echo "5. Name: WORDPRESS_CONFIG_EXTRA"
echo "6. Value: Cole TODO o conteúdo acima (entre as linhas ═)"
echo "7. Clique 'Add'"
echo ""
echo "💾 Salvar em arquivo:"
echo "   O conteúdo também foi salvo em: wordpress-config-extra.txt"
echo ""

# Salvar em arquivo
OUTPUT_FILE="wordpress-config-extra.txt"
{
    echo "$KEYS"
    cat << 'EOF'

/* Force HTTPS */
define('FORCE_SSL_ADMIN', true);
if (strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false) {
    $_SERVER['HTTPS'] = 'on';
}

/* Memory Limits */
define('WP_MEMORY_LIMIT', '256M');
define('WP_MAX_MEMORY_LIMIT', '512M');

/* Security */
define('DISALLOW_FILE_EDIT', true);

/* Performance */
define('WP_POST_REVISIONS', 5);
define('AUTOSAVE_INTERVAL', 300);
define('EMPTY_TRASH_DAYS', 30);
EOF
} > "$OUTPUT_FILE"

echo "✅ Arquivo criado: $OUTPUT_FILE"
echo ""
echo "🚀 Próximo passo: Adicione esta variável no Railway e faça deploy!"
