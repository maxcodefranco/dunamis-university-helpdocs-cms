#!/usr/bin/env python3
"""
Script para automatizar deploy no Railway usando GraphQL API
Projeto: genesiz-studio
"""

import json
import os
import subprocess
import sys
from pathlib import Path

# Configurações
PROJECT_ID = "bd388c2c-16bd-418f-90cb-d68d01e2fb16"
MYSQL_SERVICE_NAME = "university-dunamis-helpdocs-db"
WP_SERVICE_NAME = "university-dunamis-helpdocs-cms"
GITHUB_REPO = "maxcodefranco/dunamis-university-helpdocs-cms"
GITHUB_BRANCH = "main"

def get_railway_token():
    """Obtém token do Railway CLI config"""
    config_path = Path.home() / '.railway' / 'config.json'
    if not config_path.exists():
        print("❌ Railway CLI não configurado. Execute 'railway login' primeiro.")
        sys.exit(1)

    with open(config_path) as f:
        config = json.load(f)
        return config.get('token')

def run_command(cmd, description):
    """Executa comando e retorna output"""
    print(f"🔧 {description}...")
    try:
        result = subprocess.run(
            cmd,
            shell=True,
            capture_output=True,
            text=True,
            check=True
        )
        return result.stdout.strip()
    except subprocess.CalledProcessError as e:
        print(f"❌ Erro: {e.stderr}")
        return None

def print_manual_steps():
    """Imprime passos manuais necessários"""
    print("\n" + "="*60)
    print("📋 PASSOS MANUAIS NECESSÁRIOS")
    print("="*60)
    print(f"\n🌐 Acesse: https://railway.app/project/{PROJECT_ID}\n")

    print("1️⃣  ADICIONAR MYSQL DATABASE:")
    print("   - Clique em '+ New' > 'Database' > 'Add MySQL'")
    print(f"   - Renomeie para: {MYSQL_SERVICE_NAME}")
    print()

    print("2️⃣  ADICIONAR WORDPRESS SERVICE:")
    print("   - Clique em '+ New' > 'GitHub Repo'")
    print(f"   - Selecione: {GITHUB_REPO}")
    print(f"   - Branch: {GITHUB_BRANCH}")
    print(f"   - Renomeie para: {WP_SERVICE_NAME}")
    print()

    print("3️⃣  CONFIGURAR VARIÁVEIS DE AMBIENTE:")
    print("   No serviço WordPress, adicione:")
    print()
    print("   WORDPRESS_DB_HOST=${{MySQL.MYSQLHOST}}:${{MySQL.MYSQLPORT}}")
    print("   WORDPRESS_DB_NAME=${{MySQL.MYSQLDATABASE}}")
    print("   WORDPRESS_DB_USER=${{MySQL.MYSQLUSER}}")
    print("   WORDPRESS_DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}")
    print("   WORDPRESS_TABLE_PREFIX=wp_")
    print("   WORDPRESS_DEBUG=0")
    print()

    print("4️⃣  GERAR WORDPRESS SECURITY KEYS:")
    print("   - Acesse: https://api.wordpress.org/secret-key/1.1/salt/")
    print("   - Copie todo o output")
    print("   - Adicione variável WORDPRESS_CONFIG_EXTRA com as chaves")
    print()

    print("5️⃣  ADICIONAR VOLUME PARA UPLOADS:")
    print(f"   No serviço {WP_SERVICE_NAME}:")
    print("   - Settings > Volumes > New Volume")
    print("   - Name: wp-content-storage")
    print("   - Mount Path: /var/www/html/wp-content/uploads")
    print()

    print("6️⃣  VERIFICAR DEPLOY:")
    print("   - O deploy iniciará automaticamente após conectar o repo")
    print("   - Acompanhe os logs no dashboard")
    print("   - Gere um domínio em Settings > Domains")
    print()

    print("="*60)
    print("📖 Documentação: DEPLOY-QUICKSTART.md")
    print("="*60)

def main():
    print("🚀 Deploy WordPress para Railway")
    print("Project: genesiz-studio")
    print("="*60)

    # Verificar Railway CLI
    version = run_command("railway --version", "Verificando Railway CLI")
    if not version:
        print("❌ Railway CLI não instalado")
        sys.exit(1)
    print(f"✅ Railway CLI: {version}")

    # Verificar login
    user = run_command("railway whoami", "Verificando login")
    if not user:
        print("❌ Não está logado no Railway")
        print("Execute: railway login")
        sys.exit(1)
    print(f"✅ Logado como: {user}")

    # Verificar se projeto está linkado
    if not Path('.railway').exists():
        print("❌ Projeto não está linkado")
        sys.exit(1)

    with open('.railway') as f:
        config = json.load(f)
        if config.get('projectId') != PROJECT_ID:
            print(f"❌ Projeto incorreto. Esperado: {PROJECT_ID}")
            sys.exit(1)

    print(f"✅ Projeto linkado: {PROJECT_ID}")

    # Verificar git status
    status = run_command("git status --porcelain", "Verificando git")
    if status:
        print("⚠️  Você tem mudanças não commitadas")
        commit = input("Deseja commitá-las? (s/n): ")
        if commit.lower() == 's':
            run_command("git add .", "Adicionando arquivos")
            run_command('git commit -m "chore: railway setup"', "Commitando")
            run_command("git push origin main", "Fazendo push")

    print("\n✅ Projeto pronto para deploy!")
    print_manual_steps()

    # Abrir browser (opcional)
    open_browser = input("\n🌐 Deseja abrir o dashboard do Railway? (s/n): ")
    if open_browser.lower() == 's':
        url = f"https://railway.app/project/{PROJECT_ID}"
        subprocess.run(f"xdg-open {url} 2>/dev/null || open {url} 2>/dev/null || start {url}", shell=True)

if __name__ == "__main__":
    try:
        main()
    except KeyboardInterrupt:
        print("\n\n❌ Cancelado pelo usuário")
        sys.exit(1)
    except Exception as e:
        print(f"\n❌ Erro: {e}")
        sys.exit(1)
