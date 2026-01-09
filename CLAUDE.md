# Claude Code Configuration

## Context7 Configuration

Este projeto utiliza Context7 para auxiliar no desenvolvimento WordPress.

### Bibliotecas

```yaml
contexts:
  - name: wordpress-core
    type: github
    repo: wordpress/wordpress
    description: Core WordPress codebase para referência de implementação
    paths:
      - wp-includes/
      - wp-admin/
      - wp-content/themes/
    usage: |
      Use esta biblioteca para:
      - Entender estrutura de temas WordPress
      - Referência para template tags
      - Padrões de desenvolvimento WordPress
      - Hooks e filters
      - APIs do WordPress (Post Types, Taxonomies, Blocks)

  - name: tailwindcss
    type: website
    url: https://tailwindcss.com
    description: Tailwind CSS v4 framework documentation
    usage: |
      Use esta biblioteca para:
      - Referência de classes utilitárias do Tailwind v4
      - Componentes e patterns
      - Configuração do @tailwindcss/browser
      - Responsive design breakpoints
      - Cores, tipografia e espaçamentos
      - Novidades da v4 (script-based approach)
      - Best practices para performance
      - Migração de v3 para v4 (CSS → JavaScript)
```

## Diretrizes de Desenvolvimento

### Tema Custom - HelpDocs

**Estrutura:**
- Local: `wp-content/themes/helpdocs/`
- Padrões: WordPress Coding Standards
- Framework CSS: Tailwind CSS v4
- Fonte: Montserrat (Google Fonts)

**Arquitetura:**
- Template hierarchy do WordPress
- Blocks customizados para Gutenberg
- Layouts condicionais por categoria
- Sistema de feedback customizado

### Branding
- Cor primária (roxo): `#190e2ca8`
- Cor secundária (laranja): `#fa5329`
- Logo: https://cdn.prod.website-files.com/64f6f8f3d0b3d9a2cf477aed/65bfa16662ed5413a33112fc_FD-LOGO-p-500.png

### Referências Úteis

**WordPress Developer Reference:**
- Template Hierarchy: https://developer.wordpress.org/themes/basics/template-hierarchy/
- Template Tags: https://developer.wordpress.org/themes/basics/template-tags/
- Block Editor: https://developer.wordpress.org/block-editor/
- Hooks: https://developer.wordpress.org/plugins/hooks/

**Tailwind CSS:**
- Docs: https://tailwindcss.com/docs
- Versão: **v4** (@tailwindcss/browser via jsDelivr CDN)
- Integration: Via `@tailwindcss/browser` script (desenvolvimento) ou PostCSS build (produção)
- Script CDN: `https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4`
- Context7: Use `websites/tailwindcss` para referência de classes e componentes
- Classes customizadas: Ver `assets/css/custom.css`
- Breakpoints: sm (640px), md (768px), lg (1024px), xl (1280px), 2xl (1536px)

## Notas de Implementação

### WordPress
- Use WordPress template hierarchy para layouts diferenciados
- Categoria "Manuais" deve usar `category-manuais.php` com sidebar
- Sistema de feedback deve usar AJAX e nonce para segurança
- Blocks customizados devem ser registrados via `register_block_type()`
- Lazy load de imagens é nativo desde WP 5.5+

### Tailwind CSS (v4)

- **Versão**: Usando Tailwind CSS v4 via `@tailwindcss/browser@4` (script JavaScript)
- **Implementação WordPress**: `wp_enqueue_script('tailwindcss', 'https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4')`
- **Diferença v4**: Usa script JS ao invés de arquivo CSS tradicional
- **Cores da marca**: Use `text-[#190e2ca8]` (roxo) e `text-[#fa5329]` (laranja) ou classes customizadas
- **Responsividade**: Use prefixos md:, lg: para adaptar layouts
- **Componentes customizados**: Ver classes `.help-card`, `.btn-primary`, `.btn-secondary` em `custom.css`
- **Grid layouts**: Use `grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3` para layouts responsivos
- **Espaçamentos**: Siga escala padrão do Tailwind (4px base: p-4, mt-8, gap-6, etc)
- **Hover states**: Sempre adicione transições suaves com `transition-colors` ou `transition-all`
- **Typography plugin**: Disponível para estilização de conteúdo com classe `prose`
- **Context7**: Consulte `websites/tailwindcss` para referência de classes e componentes v4

### GSAP (GreenSock Animation Platform)

**Versão e Plugins:**
- **GSAP Core**: v3.12.5
- **ScrollTrigger Plugin**: v3.12.5
- **CDN**: jsDelivr (`https://cdn.jsdelivr.net/npm/gsap@3.12.5/`)
- **Documentação oficial**: https://greensock.com/docs/

**Implementação WordPress:**
```php
// functions.php - Enqueue GSAP
wp_enqueue_script('gsap', 'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js', array(), '3.12.5', true);
wp_enqueue_script('gsap-scrolltrigger', 'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js', array('gsap'), '3.12.5', true);
wp_enqueue_script('helpdocs-animations', HELPDOCS_THEME_URI . '/assets/js/animations.js', array('gsap', 'gsap-scrolltrigger'), HELPDOCS_THEME_VERSION, true);
```

**Padrões de Animação Implementados:**

1. **Hero Section Animations** (`initHeroAnimations`)
   - Timeline sequencial para fade-in de título, descrição e formulário
   - Uso de delays e overlap (`-=0.4`) para fluência
   - Easing: `power3.out` para movimento natural

2. **Card Animations** (`initCardAnimations`)
   - Scroll-triggered reveal com ScrollTrigger
   - Stagger delay (0.1s) para efeito cascata
   - Hover animations com lift effect (`y: -8`)
   - Start trigger: `top 85%` para início antes do elemento estar visível

3. **Scroll Reveal** (`initScrollReveal`)
   - Animações genéricas para headings (slide from left)
   - Parágrafos com fade-in bottom-up
   - Botões com scale + bounce effect (`ease: 'back.out(1.7)'`)
   - Toggle actions: `play none none reverse` para reverter ao scroll up

4. **Header Hide/Show** (`initHeaderAnimation`)
   - Esconde header ao scroll down (após 100px)
   - Mostra header ao scroll up
   - Adiciona box-shadow dinamicamente
   - Usa `ScrollTrigger.create()` com `onUpdate` callback

5. **Smooth Scroll** (`initSmoothScroll`)
   - Scroll suave para âncoras internas
   - GSAP ScrollTo plugin (implícito)
   - Offset de 100px para compensar sticky header
   - Duration: 1s, Easing: `power3.inOut`

6. **TOC Animations** (`initTocAnimations`)
   - Fade-in sidebar do índice
   - Stagger items (delay 0.05s)
   - Highlight ativo com pulse animation
   - Uso de `yoyo` e `repeat` para efeito de pulso

7. **Feedback Buttons** (`initFeedbackAnimations`)
   - Scale animation ao clicar
   - Transição de cor ao ativar
   - GSAP para animar backgroundColor
   - onComplete callback para aplicar classe

8. **Parallax Effect** (`initParallax`)
   - Scroll parallax em backgrounds
   - Uso de `scrub: 1` para movimento suave
   - Range: `top bottom` até `bottom top`
   - Performance: usa `ease: 'none'` para scrub

9. **List Animations** (`initListAnimations`)
   - Fade-in progressivo de items
   - Stagger baseado no index (0.05s)
   - Slide from left (`x: -20`)
   - Trigger: `top 95%` para início tardio

**Best Practices:**

✅ **DO:**
- Use `gsap.registerPlugin(ScrollTrigger)` no início do arquivo
- Aguarde `DOMContentLoaded` antes de inicializar animações
- Use `power2.out` ou `power3.out` para easings naturais
- Adicione `toggleActions: 'play none none reverse'` para reversibilidade
- Use `defaults: { ease: 'power3.out' }` em timelines para consistência
- Verifique existência do elemento antes de animar (`if (!element) return;`)
- Use delays pequenos (0.1-0.3s) para stagger effects
- Adicione `duration` explícita (evite defaults inesperados)

❌ **DON'T:**
- Não anime propriedades que causam reflow (width, height) sem necessidade
- Evite animar muitos elementos simultaneamente (performance)
- Não use delays grandes (>1s) - usuário não vai esperar
- Evite animações em mobile se prejudicar performance
- Não esqueça de limpar ScrollTriggers ao destruir componentes
- Não use `ease: 'linear'` - fica robótico (use power easings)

**Performance:**

- GSAP usa `requestAnimationFrame` internamente (60fps ideal)
- ScrollTrigger otimiza recálculos com debounce
- Animações de `transform` e `opacity` são hardware-accelerated
- Use `will-change` CSS para elementos que serão animados frequentemente
- Considere `matchMedia` para desabilitar animações em mobile:
  ```javascript
  const mm = gsap.matchMedia();
  mm.add("(min-width: 768px)", () => {
      // Animações desktop apenas
  });
  ```

**Debugging:**

- Use `markers: true` em ScrollTrigger para visualizar triggers:
  ```javascript
  scrollTrigger: {
      trigger: element,
      markers: true // Remover em produção
  }
  ```
- Console log de timelines: `timeline.eventCallback('onComplete', () => console.log('done'))`
- GSAP DevTools (plugin pago): https://greensock.com/gsap-devtools/

**Recursos Adicionais:**

- **Cheat Sheet**: https://greensock.com/cheatsheet/
- **Ease Visualizer**: https://greensock.com/ease-visualizer/
- **CodePen Demos**: https://codepen.io/GreenSock/
- **Forum**: https://greensock.com/forums/
- **Learning Center**: https://greensock.com/learning/
