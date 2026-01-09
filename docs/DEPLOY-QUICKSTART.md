# 🚀 Deploy Rápido no Railway

## Resumo Executivo

Este projeto WordPress está pronto para deploy no Railway. Siga os passos abaixo para fazer o deploy em menos de 10 minutos.

## Pré-requisitos

- ✅ Código já está no GitHub: `maxcodefranco/dunamis-university-helpdocs-cms`
- ✅ Dockerfile configurado
- ✅ Railway CLI instalado
- ✅ Logado no Railway como Max Franco

## Deploy em 5 Passos

### 1. Acessar Dashboard do Railway

```
https://railway.app/project/genesiz-studio
```

### 2. Criar Banco de Dados MySQL

1. No projeto `genesiz-studio`, clique em **"+ New"**
2. Selecione **"Database"** > **"Add MySQL"**
3. Após criado, clique no serviço MySQL
4. Vá em **"Settings"** > renomeie para: `university-dunamis-helpdocs-db`
5. ✅ Anote as credenciais (ou use referências Railway)

### 3. Criar Serviço WordPress

1. No projeto `genesiz-studio`, clique em **"+ New"**
2. Selecione **"GitHub Repo"**
3. Escolha: `maxcodefranco/dunamis-university-helpdocs-cms`
4. Railway detectará automaticamente o Dockerfile
5. Após criado, renomeie para: `university-dunamis-helpdocs-cms`

### 4. Configurar Variáveis de Ambiente

No serviço WordPress, vá em **"Variables"** e adicione:

```env
# Database (usando referências do Railway)
WORDPRESS_DB_HOST=${{MySQL.MYSQLHOST}}:${{MySQL.MYSQLPORT}}
WORDPRESS_DB_NAME=${{MySQL.MYSQLDATABASE}}
WORDPRESS_DB_USER=${{MySQL.MYSQLUSER}}
WORDPRESS_DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}

# WordPress Config
WORDPRESS_TABLE_PREFIX=wp_
WORDPRESS_DEBUG=0
```

**Gerar Security Keys:**
1. Acesse: https://api.wordpress.org/secret-key/1.1/salt/
2. Copie todo o output
3. Adicione variável `WORDPRESS_CONFIG_EXTRA` com as chaves

Exemplo:
```env
WORDPRESS_CONFIG_EXTRA=define('AUTH_KEY', 'xyz...'); define('SECURE_AUTH_KEY', 'abc...');
```

### 5. Adicionar Volume para Uploads

1. No serviço `university-dunamis-helpdocs-cms`
2. Vá em **"Settings"** > **"Volumes"**
3. Clique em **"+ New Volume"**
4. Configure:
   - **Name**: `wp-content-storage`
   - **Mount Path**: `/var/www/html/wp-content/uploads`
5. Clique em **"Add"**

## ✅ Verificar Deploy

Após alguns minutos:

1. O deploy completará automaticamente
2. Clique em **"Settings"** > **"Domains"**
3. Gere um domínio Railway: `Generate Domain`
4. Acesse o domínio gerado
5. Complete instalação do WordPress

## 🔧 Configuração Pós-Deploy

### Instalar WordPress

1. Acesse o domínio gerado
2. Selecione **idioma**: Português Brasil
3. Preencha informações do site:
   - **Título**: Dunamis University - HelpDocs
   - **Usuário**: admin (ou escolha outro)
   - **Senha**: (senha forte)
   - **Email**: seu-email@dominio.com
4. Clique em **"Instalar WordPress"**

### Ativar Tema HelpDocs

1. Login no admin: `/wp-admin`
2. Vá em **"Aparência"** > **"Temas"**
3. Ative o tema **"HelpDocs"**

### Configurar Permalinks

1. Vá em **"Configurações"** > **"Links permanentes"**
2. Selecione **"Nome do post"**
3. Salve

## 📊 Monitoramento

- **Logs**: Railway Dashboard > Serviço > "Deployments" > Click no deploy
- **Métricas**: Railway Dashboard > Serviço > "Metrics"
- **Banco**: Use Railway Dashboard > MySQL > "Data" para acessar

## 🔐 Segurança

Após deploy:

1. ✅ Force HTTPS (já configurado no Dockerfile)
2. ✅ Desabilite edição de arquivos via admin
3. ✅ Configure backup automático do banco
4. ✅ Use senhas fortes
5. ✅ Mantenha WordPress e plugins atualizados

## 🌐 Domínio Customizado (Opcional)

1. No Railway Dashboard > Serviço > "Settings" > "Domains"
2. Clique em "Custom Domain"
3. Adicione seu domínio
4. Configure DNS conforme instruções
5. Adicione variáveis de ambiente:
   ```env
   WP_HOME=https://seu-dominio.com
   WP_SITEURL=https://seu-dominio.com
   ```

## 🆘 Troubleshooting

### Deploy Falhou

```bash
# Ver logs
railway logs --service university-dunamis-helpdocs-cms
```

### Banco não Conecta

1. Verifique variáveis de ambiente
2. Confirme que MySQL service está rodando
3. Teste conexão: Railway Dashboard > MySQL > "Connect"

### Uploads não Funcionam

1. Verifique volume criado e montado
2. Path correto: `/var/www/html/wp-content/uploads`
3. Reinicie o serviço

### Site Lento

1. Aumente recursos no Railway Dashboard
2. Configure cache (W3 Total Cache ou WP Super Cache)
3. Use CDN (CloudFlare)

## 📚 Documentação

- Completa: [RAILWAY.md](RAILWAY.md)
- Desenvolvimento local: [QUICKSTART.md](QUICKSTART.md)
- Instruções do projeto: [README.md](README.md)

## ✅ Checklist Pós-Deploy

- [ ] WordPress instalado e configurado
- [ ] Tema HelpDocs ativado
- [ ] Permalinks configurados
- [ ] Security keys configurados
- [ ] Volume de uploads funcionando
- [ ] Domínio customizado (opcional)
- [ ] Backup configurado
- [ ] SSL/HTTPS funcionando
- [ ] Testes de funcionalidade completos

## 🎉 Pronto!

Seu WordPress está no ar! Acesse e comece a criar conteúdo.

---

**Suporte:**
- Railway Docs: https://docs.railway.app
- GitHub Issues: https://github.com/maxcodefranco/dunamis-university-helpdocs-cms/issues
- Railway Discord: https://discord.gg/railway
