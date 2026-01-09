# 🚨 AÇÃO URGENTE - Configurar Variáveis no Railway

## O que foi feito:
✅ Dockerfile simplificado ao máximo (apenas WordPress + wp-content)
✅ railway.toml simplificado
✅ Push feito - deploy em progresso

## ⚠️ AÇÃO NECESSÁRIA AGORA:

### 1. Acesse o Dashboard
```
https://railway.app/project/bd388c2c-16bd-418f-90cb-d68d01e2fb16
```

### 2. Configure Variáveis de Ambiente

No serviço **university-dunamis-helpdocs-cms**, aba **"Variables"**:

#### Adicione estas variáveis (COPIE E COLE):

```
WORDPRESS_DB_HOST=${{MySQL.MYSQLHOST}}:${{MySQL.MYSQLPORT}}
WORDPRESS_DB_NAME=${{MySQL.MYSQLDATABASE}}
WORDPRESS_DB_USER=${{MySQL.MYSQLUSER}}
WORDPRESS_DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}
WORDPRESS_TABLE_PREFIX=wp_
```

**IMPORTANTE**:
- Use EXATAMENTE `${{MySQL.MYSQLHOST}}` (com chaves duplas)
- O nome `MySQL` deve corresponder ao nome do seu serviço MySQL
- Se o serviço MySQL tem outro nome, ajuste

### 3. Verificar Nome do Serviço MySQL

1. No dashboard, veja o nome EXATO do serviço MySQL
2. Se for diferente de "MySQL", ajuste as variáveis:
   - Se for "university-dunamis-helpdocs-db", use:
   ```
   WORDPRESS_DB_HOST=${{university-dunamis-helpdocs-db.MYSQLHOST}}:${{university-dunamis-helpdocs-db.MYSQLPORT}}
   ```

### 4. Aguardar Deploy (2-3 minutos)

O Railway está fazendo rebuild agora. Aguarde até ver:
- ✅ Build: Success
- ✅ Deploy: Active

### 5. Testar

Após deploy completo (2-3 min):
```bash
curl -I https://university-dunamis-helpdocs-cms-production.up.railway.app
```

Esperado: **HTTP 200** ou **HTTP 302** (não 404 ou 502)

---

## Se ainda falhar:

### Opção A: Verificar Logs
```bash
railway logs
```

### Opção B: Testar Localmente
```bash
docker build -t test-wp .
docker run -p 8080:80 test-wp
```

Acesse http://localhost:8080 - deve funcionar

### Opção C: Usar Imagem Pronta
Se nada funcionar, podemos usar Railway template WordPress pronto.

---

**Tempo estimado para fix completo: 5 minutos**
**Próxima verificação: 3 minutos após configurar variáveis**
