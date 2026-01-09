# HelpDocs - Central de Ajuda Faculdade Dunamis

Sistema de documentação e suporte da Faculdade Dunamis com manuais, tutoriais e documentos.

![HelpDocs](https://cdn.prod.website-files.com/64f6f8f3d0b3d9a2cf477aed/65bfa16662ed5413a33112fc_FD-LOGO-p-500.png)

## Características

- **Layout Responsivo**: Totalmente adaptável para mobile, tablet e desktop
- **Tailwind CSS v4**: Framework CSS moderno usando @tailwindcss/browser (script-based)
- **Layouts Diferenciados**:
  - Home com big menus/cards
  - Manuais com sidebar e índice automático
  - Tutoriais e Documentos com layout padrão
- **Sistema de Feedback**: "Isso ajudou?" com estatísticas no admin
- **Editor Gutenberg**: Totalmente compatível com blocos do WordPress
- **Lazy Loading**: Carregamento otimizado de imagens
- **SEO Friendly**: Preparado para plugins de SEO

## Requisitos

- PHP 7.4 ou superior
- WordPress 5.9 ou superior
- MySQL 5.7 ou superior
- Docker e Docker Compose (para desenvolvimento)

## Instalação

### Desenvolvimento Local

Para desenvolvimento local, veja: **[docs/QUICKSTART.md](docs/QUICKSTART.md)**

```bash
git clone https://github.com/maxcodefranco/dunamis-university-helpdocs-cms.git
cd helpdocs-cms
cp .env.example .env
docker compose up -d
```

Acesse: http://localhost:8080

### Deploy em Produção (Railway)

🚀 **Deploy no Railway**: **[docs/DEPLOY-QUICKSTART.md](docs/DEPLOY-QUICKSTART.md)**

```bash
# Execute o script de deploy
./scripts/deploy-to-railway.py
```

**URL de Produção**: https://university-dunamis-helpdocs-cms-production.up.railway.app

#### Documentação Completa de Deploy
- [Deploy Rápido](docs/DEPLOY-QUICKSTART.md) - 5 minutos
- [Configuração Railway](docs/RAILWAY-PROJECT.md) - Detalhes do projeto
- [Setup de Volumes](docs/VOLUME-SETUP.md) - Troubleshooting

### Ativar o Tema

1. No WordPress admin, vá em **Aparência > Temas**
2. Ative o tema **HelpDocs**
3. O tema criará automaticamente a tabela de feedback

## Configuração Inicial

### 1. Crie as categorias principais

Vá em **Posts > Categorias** e crie:

- **Manuais** (slug: `manuais`)
  - Descrição: "Guias completos passo a passo"

- **Tutoriais** (slug: `tutoriais`)
  - Descrição: "Tutoriais rápidos e práticos"

- **Documentos** (slug: `documentos`)
  - Descrição: "Documentos oficiais e formulários"

### 2. Configure os menus

Vá em **Aparência > Menus**:

**Menu Principal**:
- Home
- Manuais
- Tutoriais
- Documentos
- Buscar

**Menu Rodapé**:
- Sobre
- Contato
- Política de Privacidade

Atribua os menus nas localizações:
- **Menu Principal**: primary
- **Menu Rodapé**: footer

### 3. Configure Permalinks

Vá em **Configurações > Links Permanentes**:
- Selecione **Nome do post**
- Salve as alterações

## Estrutura do Tema

```
wp-content/themes/helpdocs/
├── assets/
│   ├── css/
│   │   └── custom.css          # Estilos customizados
│   ├── js/
│   │   └── main.js             # Scripts principais
│   └── images/
├── inc/
│   └── feedback.php            # Sistema de feedback
├── templates/
│   └── feedback.php            # Template de feedback
├── 404.php                     # Página de erro
├── category.php                # Archive de categorias
├── footer.php                  # Rodapé
├── front-page.php              # Home page
├── functions.php               # Funções do tema
├── header.php                  # Cabeçalho
├── index.php                   # Template fallback
├── single.php                  # Post individual
└── style.css                   # Informações do tema
```

## Funcionalidades

### Layouts Diferenciados

#### Home (/)
- Big menus/cards clicáveis para as 3 categorias principais
- Seção de posts recentes
- Busca em destaque
- CTA para suporte

#### Manuais (/category/manuais/)
- Sidebar à esquerda com índice automático
- Gerado a partir dos headings H2 e H3
- Scroll spy para highlight da seção ativa
- Navegação entre posts

#### Tutoriais e Documentos
- Layout padrão limpo
- Grid de cards responsivo
- Imagens destacadas
- Navegação entre posts

### Sistema de Feedback

Cada post possui botões "Sim, ajudou" e "Não, preciso de mais ajuda".

**Recursos**:
- Armazenamento em tabela customizada
- Proteção contra múltiplos votos (IP + 24h)
- Estatísticas no admin
- Coluna com métricas na listagem de posts
- Taxa de utilidade calculada automaticamente

**Ver estatísticas**:
- No admin: Posts > Todos os posts
- Coluna "👍 Feedback" mostra votos e taxa

### Índice Automático (Table of Contents)

Posts da categoria "Manuais" geram automaticamente um índice:

```php
## Seção 1
Conteúdo...

### Subseção 1.1
Conteúdo...

## Seção 2
Conteúdo...
```

O índice será gerado na sidebar à esquerda.

## Branding

### Cores

- **Primária (Roxo)**: `#190e2ca8`
- **Secundária (Laranja)**: `#fa5329`

### Tipografia

- **Fonte**: Montserrat (Google Fonts)
- **Weights**: 300, 400, 500, 600, 700, 800, 900

### Logo

URL: https://cdn.prod.website-files.com/64f6f8f3d0b3d9a2cf477aed/65bfa16662ed5413a33112fc_FD-LOGO-p-500.png

## Plugins Recomendados

### SEO
- **Yoast SEO** ou **Rank Math**
  - Configure sitemap XML
  - Meta tags e Open Graph

### Cache
- **WP Super Cache** ou **W3 Total Cache**
  - Ative cache de páginas
  - Minificação de CSS/JS

### Segurança
- **Wordfence** ou **iThemes Security**
  - Firewall ativo
  - Proteção contra brute force
  - 2FA para admins

### Funcionalidades
- **Advanced Custom Fields (ACF)** - Campos customizados
- **Smush** ou **ShortPixel** - Otimização de imagens

## Desenvolvimento

### Tailwind CSS v4

O tema usa **Tailwind CSS v4** via `@tailwindcss/browser` (script JavaScript) para desenvolvimento:

```html
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
```

**Vantagens da v4:**
- Processamento em tempo real no navegador
- Não requer build process para desenvolvimento
- Suporte a todas as classes utilitárias
- Configuração inline via CSS

### Estrutura de Desenvolvimento

Para produção, recomenda-se usar o build process do Tailwind v4:

```bash
# Instalar dependências
npm install -D tailwindcss@next @tailwindcss/cli@next

# Build CSS
npm run build

# Watch mode
npm run dev
```

### Customização do Tailwind v4

Para usar Tailwind com build process (produção):

1. Crie `tailwind.config.js`:

```javascript
module.exports = {
  content: [
    './**/*.php',
    './assets/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
        'primary': '#190e2ca8',
        'secondary': '#fa5329',
      },
      fontFamily: {
        'sans': ['Oswald', 'sans-serif'],
      },
    },
  },
  plugins: [],
}
```

2. Instale dependências:

```bash
npm install -D tailwindcss @tailwindcss/typography
```

3. Crie `assets/css/tailwind.css`:

```css
@tailwind base;
@tailwind components;
@tailwind utilities;
```

4. Configure build no `package.json`:

```json
{
  "scripts": {
    "build": "tailwindcss -i ./assets/css/tailwind.css -o ./assets/css/custom.css --minify",
    "dev": "tailwindcss -i ./assets/css/tailwind.css -o ./assets/css/custom.css --watch"
  }
}
```

## Suporte e Contribuição

### Reportar Bugs

Abra uma issue descrevendo:
- O que você esperava
- O que aconteceu
- Passos para reproduzir
- Screenshots (se aplicável)

### Contribuir

1. Fork o projeto
2. Crie uma branch para sua feature (`git checkout -b feature/nova-funcionalidade`)
3. Commit suas mudanças (`git commit -m 'Adiciona nova funcionalidade'`)
4. Push para a branch (`git push origin feature/nova-funcionalidade`)
5. Abra um Pull Request

## Changelog

### v1.0.0 (2026-01-08)
- Lançamento inicial
- Layouts diferenciados por categoria
- Sistema de feedback completo
- Índice automático para manuais
- Integração com Tailwind CSS
- Tema responsivo completo

## Licença

GNU General Public License v2 or later

## Autores

Desenvolvido para a **Faculdade Dunamis**

---

**HelpDocs** - Central de Ajuda da Faculdade Dunamis
