# 🔍 CHECKLIST - Verificação no Dashboard Railway

## Status Atual
- ⏱️ **Deploy em progresso há 20+ minutos**
- ❌ **Site retorna 502 Bad Gateway**
- ✅ **Dockerfile simplificado para `FROM wordpress:latest`**
- ✅ **Variável WORDPRESS_DB_HOST corrigida**

## 🎯 AÇÕES NECESSÁRIAS NO DASHBOARD

### 1. Acesse o Dashboard
```
https://railway.app/project/bd388c2c-16bd-418f-90cb-d68d01e2fb16
```

---

### 2. Verificar Serviço MySQL

#### No serviço `university-dunamis-helpdocs-db`:

- [ ] Status está **🟢 Active** (verde)?
- [ ] Clique no serviço > Aba **"Metrics"**
  - CPU Usage > 0%?
  - Memory Usage > 0%?
- [ ] Aba **"Variables"**
  - Existe `MYSQLHOST`, `MYSQLPORT`, `MYSQLDATABASE`?
  - Anote o valor de `MYSQLHOST`

**Se MySQL não está ativo:**
1. Clique no serviço
2. Vá em "Settings" > Restart
3. Aguarde 1-2 minutos

---

### 3. Verificar Serviço WordPress

#### No serviço `university-dunamis-helpdocs-cms`:

**A. Verificar Status do Deploy**

- [ ] Clique no serviço
- [ ] Vá na aba **"Deployments"**
- [ ] Veja o deploy mais recente:
  - 🟢 **Success** = Build OK
  - 🔴 **Failed** = Build falhou
  - 🟡 **In Progress** = Ainda fazendo build

**B. Ver Build Logs**

- [ ] Clique no deployment mais recente
- [ ] Aba **"Build Logs"**
- [ ] Procure por erros:
  ```
  ERROR: ...
  FAILED: ...
  exit code 1
  ```

**C. Ver Deploy Logs (MAIS IMPORTANTE)**

- [ ] Aba **"Deploy Logs"**
- [ ] Procure por:

**✅ BOM - Apache rodando:**
```
AH00558: apache2: Could not reliably determine...
[core:notice] [pid 1] AH00094: Command line: 'apache2 -D FOREGROUND'
WordPress not found in /var/www/html - copying now...
Complete! WordPress has been successfully copied to /var/www/html
```

**❌ RUIM - Erros:**
```
Error establishing a database connection
Can't connect to MySQL server
MySQL server has gone away
Connection refused
```

---

### 4. Verificar Variáveis de Ambiente

#### No serviço WordPress, aba **"Variables"**:

Confirme que existem:

```
WORDPRESS_DB_HOST = university-dunamis-helpdocs-db.railway.internal:3306
  OU
WORDPRESS_DB_HOST = ${{university-dunamis-helpdocs-db.MYSQLHOST}}:${{university-dunamis-helpdocs-db.MYSQLPORT}}

WORDPRESS_DB_NAME = railway
WORDPRESS_DB_USER = root
WORDPRESS_DB_PASSWORD = (algum valor)
WORDPRESS_TABLE_PREFIX = wp_
```

**⚠️ CRÍTICO:** Se `WORDPRESS_DB_HOST` estiver diferente disso, corrija!

---

### 5. Ações de Correção

#### Se Build falhou:
1. Delete o serviço WordPress
2. Recrie conectando ao GitHub repo novamente
3. Configure as variáveis

#### Se Deploy logs mostram erro de DB:
1. Corrija `WORDPRESS_DB_HOST` conforme seção 4
2. Clique em **"Redeploy"**

#### Se Apache não está iniciando:
1. Verifique se o Dockerfile é apenas:
   ```dockerfile
   FROM wordpress:latest
   ```
2. Se não for, atualize no GitHub e push
3. Railway vai redeploy automaticamente

#### Se tudo parece OK mas ainda 502:
1. Anote o que você vê nos logs
2. Tire screenshot dos logs
3. Compartilhe aqui para análise

---

### 6. Teste Final

Após fazer correções e aguardar redeploy (2-3 min):

```bash
curl -I https://university-dunamis-helpdocs-cms-production.up.railway.app
```

**Esperado:**
- `HTTP/2 200 OK` ✅
- `HTTP/2 302 Found` ✅ (redirect para instalação)

**Não esperado:**
- `HTTP/2 502 Bad Gateway` ❌
- `HTTP/2 404 Not Found` ❌

---

## 📊 Diagnóstico Rápido

| Sintoma | Causa Provável | Solução |
|---------|---------------|---------|
| Build logs OK, Deploy logs mostram erro MySQL | Variável WORDPRESS_DB_HOST incorreta | Corrigir host MySQL |
| Deploy logs vazio ou container para | Container crashando ao iniciar | Ver logs, checar Dockerfile |
| Build falha | Erro no Dockerfile ou .dockerignore | Simplificar Dockerfile |
| 502 após 15+ min | Container não consegue iniciar | Verificar deploy logs |

---

## 🆘 Se Nada Funcionar

### Solução Alternativa: Usar Template Railway

1. No projeto Railway, clique **"+ New"**
2. Selecione **"Template"**
3. Busque: **"WordPress"**
4. Use template oficial do Railway
5. Depois copie manualmente o tema do `wp-content/themes/helpdocs`

---

## 📝 Informações para Debug

Se precisar de ajuda, forneça:

1. **Status do MySQL**: Active/Inactive
2. **Status do deploy WordPress**: Success/Failed/In Progress
3. **Últimas 20 linhas dos Deploy Logs**
4. **Valor da variável WORDPRESS_DB_HOST**
5. **Screenshot do dashboard**

---

**Última atualização**: Deploy em progresso
**Próxima ação**: Verificar dashboard Railway seguindo este checklist
