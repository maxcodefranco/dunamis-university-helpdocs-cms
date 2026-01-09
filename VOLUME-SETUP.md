# 📦 Configuração de Volume no Railway

## Problema: Opção de Volume não aparece

Se a opção de Volume não está aparecendo no Railway Dashboard, pode ser por alguns motivos:

## ✅ Soluções

### Solução 1: Verificar Localização no Dashboard

1. Acesse: https://railway.app/project/bd388c2c-16bd-418f-90cb-d68d01e2fb16
2. Clique no serviço: **university-dunamis-helpdocs-cms**
3. Clique na aba **"Settings"** (não "Variables"!)
4. Role a página até o final
5. Procure pela seção **"Volumes"** ou **"Storage"**
6. Deve ter um botão **"+ New Volume"** ou **"Add Volume"**

### Solução 2: Usar Railway CLI

Se o dashboard não mostrar, você pode criar via CLI:

```bash
# Certifique-se de estar no diretório do projeto
cd /home/demax/devmax/clients/dunamis/helpdocs-cms

# Link ao serviço WordPress
railway link --service university-dunamis-helpdocs-cms

# Criar volume
railway volume add --mount /var/www/html/wp-content/uploads
```

### Solução 3: Via API do Railway

Se o CLI também não funcionar, você pode usar a API GraphQL do Railway.

### Solução 4: Configuração Alternativa (Sem Volume)

Se você não conseguir criar volume, pode usar alternativas:

#### Opção A: Usar Storage Externo (Recomendado)
Use um plugin do WordPress para armazenar uploads externamente:

1. **Cloudinary** (grátis até 25GB)
   - Plugin: Cloudinary
   - Armazena imagens na nuvem

2. **AWS S3**
   - Plugin: WP Offload Media
   - Requer conta AWS

3. **Bunny.net** (mais barato)
   - Plugin: Bunny CDN
   - R$ 0.01 por GB

#### Opção B: Volume Persistente via Dockerfile

Modifique o Dockerfile para persistir dados localmente (não recomendado para produção):

```dockerfile
# Adicionar ao Dockerfile
VOLUME ["/var/www/html/wp-content/uploads"]
```

## 📊 Verificar Plano do Railway

O Railway Free tier tem limitações. Volumes podem requerer:
- **Developer Plan** ($5/mês + uso)
- Ou upgrade para um plano pago

Verifique seu plano em: https://railway.app/account/billing

## 🎯 Solução Recomendada: Cloudinary

Se volumes não estiverem disponíveis, use Cloudinary:

### 1. Criar Conta no Cloudinary
```
https://cloudinary.com/users/register/free
```

### 2. Instalar Plugin no WordPress
1. Login em `/wp-admin`
2. Plugins > Adicionar Novo
3. Busque: "Cloudinary"
4. Instale e ative

### 3. Configurar no WordPress
1. Plugins > Cloudinary
2. Conecte sua conta
3. Configure upload automático

### Vantagens:
- ✅ Grátis até 25GB
- ✅ CDN global incluído
- ✅ Otimização automática de imagens
- ✅ Backup automático
- ✅ Não depende do Railway

## 🔍 Diagnóstico

Execute este comando para verificar o que está disponível:

```bash
railway run env | grep -i volume
```

Ou verifique a documentação do projeto:

```bash
railway info
```

## 📞 Se Nada Funcionar

1. **Suporte Railway**
   - Discord: https://discord.gg/railway
   - Email: support@railway.app

2. **Verificar Status do Plano**
   ```bash
   railway whoami
   ```

3. **Upgrade Temporário**
   - Faça upgrade para Developer ($5)
   - Configure o volume
   - Depois pode downgrade (volume persiste)

## 🚨 Workaround Rápido

Se você precisa testar urgentemente SEM volume:

1. Uploads ficarão temporários (serão perdidos em redeploys)
2. Para produção, SEMPRE use:
   - Volume persistente (Railway), OU
   - Storage externo (Cloudinary, S3, etc)

## 📝 Checklist

- [ ] Tentei via Dashboard > Settings > Volumes
- [ ] Tentei via Railway CLI
- [ ] Verifiquei meu plano no Railway
- [ ] Considerei usar Cloudinary como alternativa
- [ ] Entrei em contato com suporte Railway

---

**Próximo Passo**: Tente a Solução 1 primeiro (Dashboard), depois Solução 2 (CLI), e se nada funcionar, use Cloudinary (Solução 4).
