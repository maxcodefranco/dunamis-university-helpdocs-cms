# 🔧 Troubleshooting - Deploy Railway

## Problema: Site retorna 404

Se o site https://university-dunamis-helpdocs-cms-production.up.railway.app retorna 404, siga este guia.

## 1. Verificar Status do Build

### Acesse o Dashboard
```
https://railway.app/project/bd388c2c-16bd-418f-90cb-d68d01e2fb16
```

### No serviço `university-dunamis-helpdocs-cms`:

1. Clique na aba **"Deployments"**
2. Veja o deploy mais recente:
   - 🟢 **Success** = Build OK
   - 🔴 **Failed** = Build falhou
   - 🟡 **Building** = Ainda em progresso

## 2. Ver Logs do Deploy

### Build Logs
1. Clique no deployment mais recente
2. Ver tab **"Build Logs"**
3. Procure por erros:
   ```
   ERROR: ...
   FAILED: ...
   ```

### Deploy Logs
1. Ver tab **"Deploy Logs"**
2. Procure por:
   ```
   AH00558: apache2: Could not reliably determine...
   [core:notice] [pid 1] AH00094: Command line: 'apache2 -D FOREGROUND'
   ```
   ✅ Significa que Apache iniciou

   Ou erros:
   ```
   Error establishing a database connection
   ```
   ❌ Banco não conectado

## 3. Verificar Variáveis de Ambiente

### No serviço WordPress, aba "Variables":

#### Obrigatórias:
- [ ] `WORDPRESS_DB_HOST` = `${{MySQL.MYSQLHOST}}:${{MySQL.MYSQLPORT}}`
- [ ] `WORDPRESS_DB_NAME` = `${{MySQL.MYSQLDATABASE}}`
- [ ] `WORDPRESS_DB_USER` = `${{MySQL.MYSQLUSER}}`
- [ ] `WORDPRESS_DB_PASSWORD` = `${{MySQL.MYSQLPASSWORD}}`
- [ ] `WORDPRESS_TABLE_PREFIX` = `wp_`
- [ ] `WORDPRESS_DEBUG` = `0`
- [ ] `WORDPRESS_CONFIG_EXTRA` = (security keys)

**IMPORTANTE**: As referências `${{MySQL.*}}` devem corresponder ao nome exato do serviço MySQL.

## 4. Verificar Serviço MySQL

### No dashboard, verifique:

1. Serviço MySQL está rodando?
   - Nome: `university-dunamis-helpdocs-db`
   - Status: 🟢 Active

2. MySQL tem volume anexado?
   - Volume: `mysql-volume`
   - Mount: `/var/lib/mysql`

## 5. Verificar Network

### Services devem estar na mesma network:
- WordPress e MySQL devem estar no mesmo projeto
- Railway cria network privada automática
- Usar referências `${{MySQL.*}}` garante conectividade

## 6. Erros Comuns e Soluções

### Erro: "Error establishing database connection"

**Causa**: Variáveis de ambiente incorretas

**Solução**:
1. Verifique que MySQL service existe e está ativo
2. Confirme que as variáveis usam `${{MySQL.*}}` references
3. Reinicie o serviço WordPress após corrigir variáveis

### Erro: "404 Not Found"

**Causa 1**: Deploy ainda em progresso
**Solução**: Aguarde build completar (pode levar 5-10 minutos na primeira vez)

**Causa 2**: Container não iniciou
**Solução**: Ver deploy logs para erros

**Causa 3**: Apache não está rodando
**Solução**: Verificar Dockerfile CMD está correto

### Erro: "502 Bad Gateway"

**Causa**: Container está iniciando
**Solução**: Aguarde 1-2 minutos, é normal durante startup

### Erro: Build timeout

**Causa**: Imagem Docker muito grande ou build lento
**Solução**:
1. Otimizar Dockerfile
2. Usar imagens menores
3. Adicionar `.dockerignore`

## 7. Comandos Úteis

### Ver logs em tempo real
```bash
railway logs -f
```

### Ver status
```bash
railway status
```

### Redeploy forçado
```bash
railway up --detach
```

### Ver variáveis
```bash
railway variables
```

## 8. Verificação Manual do Dockerfile

### Nosso Dockerfile:
```dockerfile
FROM wordpress:6.4-php8.2-apache
...
CMD ["apache2-foreground"]
```

### Verificar localmente:
```bash
docker build -t helpdocs-test .
docker run -p 8080:80 helpdocs-test
```

Se funcionar localmente, problema é na configuração Railway.

## 9. Testes de Conectividade

### Testar se o domínio resolve:
```bash
curl -I https://university-dunamis-helpdocs-cms-production.up.railway.app
```

Esperado:
```
HTTP/2 200 OK  ✅ (WordPress instalado)
HTTP/2 302 Found  ✅ (WordPress redirect para instalação)
HTTP/2 404 Not Found + x-railway-fallback: true  ❌ (Serviço não está rodando)
HTTP/2 502 Bad Gateway  ⏳ (Serviço iniciando)
```

## 10. Reset Completo (Último Recurso)

Se nada funcionar:

1. **Deletar serviço WordPress** (mantém MySQL e dados)
2. **Recriar serviço**:
   - Conectar GitHub repo novamente
   - Reconfigurar variáveis
   - Reanexar volume

3. **Ou usar Railway CLI**:
```bash
railway down
railway up --detach
```

## 11. Suporte Railway

Se o problema persistir:

1. **Discord Railway**: https://discord.gg/railway
   - Canal #help
   - Compartilhe logs e erro específico

2. **Railway Status**: https://status.railway.app
   - Verificar se há incidentes

3. **Railway Docs**: https://docs.railway.app/troubleshoot/fixing-common-errors

## 12. Checklist Final

- [ ] MySQL service está ativo
- [ ] WordPress service está ativo
- [ ] Todas variáveis de ambiente configuradas
- [ ] Variáveis usam `${{MySQL.*}}` references corretas
- [ ] Volume de uploads anexado
- [ ] Build logs sem erros
- [ ] Deploy logs mostram Apache rodando
- [ ] Aguardou 5-10 minutos após primeiro deploy

## 📊 Status Esperado (Normal)

```
✅ MySQL: Active, usando mysql-volume
✅ WordPress: Active, usando university-dunamis-helpdocs-cms-volume
✅ Build: Success
✅ Deploy: Running
✅ URL: https://university-dunamis-helpdocs-cms-production.up.railway.app
✅ HTTP: 200 ou 302 (redirect para instalação WordPress)
```

---

**Próximo passo**: Acesse o dashboard e siga este guia para identificar o problema específico.
