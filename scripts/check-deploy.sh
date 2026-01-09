#!/bin/bash

echo "🔍 Verificando Deploy no Railway"
echo "================================="
echo ""

# Projeto info
echo "📋 Projeto:"
railway status
echo ""

# Testar conexão com o site
echo "🌐 Testando URL de produção..."
URL="https://university-dunamis-helpdocs-cms-production.up.railway.app"

HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" --max-time 10 "$URL" 2>/dev/null)

if [ "$HTTP_CODE" = "200" ]; then
    echo "✅ Site está online e respondendo (HTTP $HTTP_CODE)"
elif [ "$HTTP_CODE" = "000" ]; then
    echo "⏳ Site não está respondendo ainda (timeout ou não iniciou)"
elif [ "$HTTP_CODE" = "502" ] || [ "$HTTP_CODE" = "503" ]; then
    echo "🔄 Site está iniciando (HTTP $HTTP_CODE - Bad Gateway/Service Unavailable)"
else
    echo "⚠️  HTTP Status: $HTTP_CODE"
fi

echo ""
echo "🔗 Acesse o dashboard para mais detalhes:"
echo "   https://railway.app/project/bd388c2c-16bd-418f-90cb-d68d01e2fb16"
echo ""
echo "📊 Para ver logs em tempo real:"
echo "   railway logs"
