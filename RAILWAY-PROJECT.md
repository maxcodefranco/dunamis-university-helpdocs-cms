# 🚂 Railway Project Configuration

## Project Information

- **Project Name**: genesiz-studio
- **Project ID**: `bd388c2c-16bd-418f-90cb-d68d01e2fb16`
- **Environment**: production
- **Repository**: https://github.com/maxcodefranco/dunamis-university-helpdocs-cms

## Services to Create

### 1. MySQL Database
- **Name**: `university-dunamis-helpdocs-db`
- **Type**: MySQL 8.0
- **Purpose**: WordPress database

### 2. WordPress Application
- **Name**: `university-dunamis-helpdocs-cms`
- **Type**: GitHub Repository
- **Repository**: maxcodefranco/dunamis-university-helpdocs-cms
- **Branch**: main
- **Build**: Dockerfile (auto-detected)

## 🚀 Quick Deploy

### Option 1: Using Python Script (Recommended)

```bash
./deploy-to-railway.py
```

This script will:
- ✅ Verify Railway CLI installation and login
- ✅ Check project linkage
- ✅ Verify git status
- ✅ Display step-by-step manual instructions
- ✅ Optionally open Railway dashboard

### Option 2: Using Bash Script

```bash
./setup-railway.sh
```

### Option 3: Direct Dashboard Access

Open: https://railway.app/project/bd388c2c-16bd-418f-90cb-d68d01e2fb16

## 📋 Step-by-Step Configuration

### Step 1: Add MySQL Database

1. Click **"+ New"** in the project
2. Select **"Database"** > **"Add MySQL"**
3. Wait for provisioning
4. Click on the MySQL service
5. Go to **"Settings"** > rename to: `university-dunamis-helpdocs-db`

### Step 2: Add WordPress Service

1. Click **"+ New"** in the project
2. Select **"GitHub Repo"**
3. Choose: `maxcodefranco/dunamis-university-helpdocs-cms`
4. Branch: `main`
5. Railway will auto-detect Dockerfile
6. Rename service to: `university-dunamis-helpdocs-cms`

### Step 3: Configure Environment Variables

In the WordPress service, add these variables:

#### Database Connection (use Railway references)
```env
WORDPRESS_DB_HOST=${{MySQL.MYSQLHOST}}:${{MySQL.MYSQLPORT}}
WORDPRESS_DB_NAME=${{MySQL.MYSQLDATABASE}}
WORDPRESS_DB_USER=${{MySQL.MYSQLUSER}}
WORDPRESS_DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}
```

#### WordPress Configuration
```env
WORDPRESS_TABLE_PREFIX=wp_
WORDPRESS_DEBUG=0
```

#### Security Keys (generate first!)

1. Visit: https://api.wordpress.org/secret-key/1.1/salt/
2. Copy the entire output
3. Add variable `WORDPRESS_CONFIG_EXTRA` with the keys

Example format:
```php
define('AUTH_KEY',         'put your unique phrase here');
define('SECURE_AUTH_KEY',  'put your unique phrase here');
define('LOGGED_IN_KEY',    'put your unique phrase here');
define('NONCE_KEY',        'put your unique phrase here');
define('AUTH_SALT',        'put your unique phrase here');
define('SECURE_AUTH_SALT', 'put your unique phrase here');
define('LOGGED_IN_SALT',   'put your unique phrase here');
define('NONCE_SALT',       'put your unique phrase here');
```

#### Optional: Production Settings
```env
WP_MEMORY_LIMIT=256M
WP_MAX_MEMORY_LIMIT=512M
FORCE_SSL_ADMIN=true
DISALLOW_FILE_EDIT=true
```

### Step 4: Add Volume for Uploads

1. Go to WordPress service
2. Click **"Settings"** > **"Volumes"**
3. Click **"+ New Volume"**
4. Configure:
   - **Name**: `wp-content-storage`
   - **Mount Path**: `/var/www/html/wp-content/uploads`
5. Click **"Add"**

### Step 5: Deploy & Verify

1. Deployment starts automatically after connecting repo
2. Monitor logs: **Deployments** tab > click on deployment
3. Wait for "Build successful" and "Deployment live"
4. Generate domain: **Settings** > **Domains** > **Generate Domain**
5. Access the generated URL

### Step 6: WordPress Installation

1. Access the Railway-generated domain
2. Select language: **Português Brasil**
3. Fill in site information:
   - **Site Title**: Dunamis University - HelpDocs
   - **Username**: (choose admin username)
   - **Password**: (strong password)
   - **Email**: your-email@domain.com
4. Click **"Install WordPress"**
5. Login to `/wp-admin`
6. Go to **"Appearance"** > **"Themes"**
7. Activate **"HelpDocs"** theme
8. Configure permalinks: **Settings** > **Permalinks** > **Post name**

## 🔍 Monitoring

### View Logs
```bash
railway logs
```

### View Metrics
Railway Dashboard > Service > Metrics

### Database Access
Railway Dashboard > MySQL service > Data tab

## 🔐 Security Checklist

- [x] HTTPS enabled (automatic on Railway)
- [x] Security keys configured
- [x] Strong admin password
- [ ] Disable file editing via admin
- [ ] Configure automatic backups
- [ ] Update WordPress and plugins regularly
- [ ] Configure firewall rules (if needed)

## 🌐 Custom Domain (Optional)

1. WordPress service > **Settings** > **Domains**
2. Click **"Custom Domain"**
3. Enter your domain: `helpdocs.dunamis.com`
4. Configure DNS:
   - Type: CNAME
   - Name: helpdocs
   - Value: [provided by Railway]
5. Add environment variables:
   ```env
   WP_HOME=https://helpdocs.dunamis.com
   WP_SITEURL=https://helpdocs.dunamis.com
   ```
6. Update WordPress settings in admin panel

## 📊 Resource Configuration

### Default Resources
- **CPU**: Shared
- **Memory**: 512MB (default)
- **Disk**: Volume size for uploads

### Scaling (if needed)
- Upgrade plan for more resources
- Add Redis for caching
- Configure CDN for static assets
- Implement CloudFlare caching

## 🆘 Troubleshooting

### Build Failed
```bash
railway logs --deployment
```
Check Dockerfile syntax and dependencies

### Database Connection Error
- Verify environment variables are correct
- Check MySQL service is running
- Confirm service linking

### Uploads Not Working
- Verify volume is created
- Check mount path: `/var/www/html/wp-content/uploads`
- Confirm volume is attached to service

### Site Loading Slow
- Check metrics for resource usage
- Consider upgrading plan
- Enable caching plugins
- Use CDN for assets

### 502 Bad Gateway
- Service is starting (wait 1-2 minutes)
- Check deployment logs for errors
- Verify Dockerfile CMD is correct

## 📚 Additional Resources

- **Full Documentation**: [RAILWAY.md](RAILWAY.md)
- **Quick Start**: [DEPLOY-QUICKSTART.md](DEPLOY-QUICKSTART.md)
- **Local Development**: [QUICKSTART.md](QUICKSTART.md)
- **Railway Docs**: https://docs.railway.app
- **Railway Discord**: https://discord.gg/railway

## 🎯 Success Metrics

After successful deployment:
- ✅ WordPress accessible via Railway domain
- ✅ Database connection working
- ✅ HelpDocs theme active
- ✅ Uploads working (test by adding media)
- ✅ Permalinks configured
- ✅ HTTPS working
- ✅ No errors in logs

## 💰 Cost Estimation

Railway pricing:
- **Free tier**: $5 credit/month (limited)
- **Developer**: $5/month + usage
- **Estimated cost**: $10-20/month for small site
  - WordPress service: ~$5-10
  - MySQL database: ~$3-5
  - Volume storage: ~$1-3

## 📞 Support

- **Project Issues**: [GitHub Issues](https://github.com/maxcodefranco/dunamis-university-helpdocs-cms/issues)
- **Railway Support**: support@railway.app
- **Railway Discord**: https://discord.gg/railway
- **WordPress.org Forums**: https://wordpress.org/support/

---

**Last Updated**: 2026-01-09
**Project Status**: Ready for deployment
**Next Step**: Follow Step 1 above to create MySQL database
