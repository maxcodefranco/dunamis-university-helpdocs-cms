# Guia Rápido - HelpDocs

## Início Rápido em 5 minutos

### 1. Acesse o WordPress

```
URL: http://localhost:8082
Admin: http://localhost:8082/wp-admin
```

### 2. Ative o Tema

1. Faça login no WordPress
2. Vá em **Aparência > Temas**
3. Ative o tema **HelpDocs**

### 3. Crie as Categorias

Vá em **Posts > Categorias** e adicione:

| Nome | Slug | Descrição |
|------|------|-----------|
| Manuais | manuais | Guias completos passo a passo |
| Tutoriais | tutoriais | Tutoriais rápidos e práticos |
| Documentos | documentos | Documentos oficiais e formulários |

### 4. Configure Permalinks

1. Vá em **Configurações > Links Permanentes**
2. Selecione **Nome do post**
3. Salve

### 5. Crie Conteúdo de Teste

#### Manual de Exemplo

1. Vá em **Posts > Adicionar novo**
2. **Título**: "Como usar o sistema acadêmico"
3. **Conteúdo**:

```
## Introdução
Bem-vindo ao manual do sistema acadêmico...

## Fazendo login
Para acessar o sistema...

### Primeiro acesso
Se é seu primeiro acesso...

### Recuperação de senha
Caso tenha esquecido sua senha...

## Navegando pelo sistema
O menu principal possui...

### Área do aluno
Na área do aluno você pode...

## Dúvidas frequentes
Confira as perguntas mais comuns...
```

4. **Categoria**: Selecione "Manuais"
5. **Imagem destacada**: Adicione uma imagem (opcional)
6. **Publicar**

#### Tutorial de Exemplo

1. **Título**: "Como emitir histórico escolar"
2. **Conteúdo**: Tutorial curto
3. **Categoria**: "Tutoriais"
4. **Publicar**

#### Documento de Exemplo

1. **Título**: "Regulamento Acadêmico 2026"
2. **Conteúdo**: Documento ou link para download
3. **Categoria**: "Documentos"
4. **Publicar**

### 6. Verifique o Resultado

Visite:
- **Home**: http://localhost:8082
- **Manuais**: http://localhost:8082/category/manuais/
- **Post de Manual**: Veja o sidemenu automático
- **Tutoriais**: http://localhost:8082/category/tutoriais/
- **Documentos**: http://localhost:8082/category/documentos/

## Recursos do Tema

### 🏠 Home Page
- Cards grandes para cada categoria
- Posts recentes
- Busca em destaque

### 📚 Manuais
- Sidebar com índice automático
- Gerado dos H2 e H3 do conteúdo
- Scroll spy ativo

### 👍 Sistema de Feedback
- Aparece automaticamente em cada post
- Votos salvos por IP (24h)
- Estatísticas no admin

### 📱 Responsivo
- Mobile-first
- Breakpoints: 640px, 768px, 1024px
- Menu hamburger no mobile

## Atalhos Úteis

### Acessar banco de dados
```
URL: http://localhost:8081
Servidor: db
Usuário: wordpress
Senha: wordpress_secure_pass
```

### Ver logs do Docker
```bash
docker compose logs -f wordpress
```

### Restart containers
```bash
docker compose restart
```

### Parar tudo
```bash
docker compose down
```

## Próximos Passos

1. **Instale plugins recomendados**:
   - Yoast SEO (SEO)
   - WP Super Cache (Cache)
   - Wordfence (Segurança)

2. **Configure menus**:
   - Aparência > Menus
   - Crie menu principal e footer

3. **Adicione mais conteúdo**:
   - Mínimo 3-5 posts por categoria
   - Use headings (H2, H3) nos manuais

4. **Teste feedback**:
   - Clique em "Sim, ajudou" em um post
   - Veja as estatísticas no admin

5. **Personalize**:
   - Adicione logo customizado (se necessário)
   - Ajuste cores no `custom.css`
   - Adicione páginas extras (Sobre, Contato)

## Dicas

### Para Manuais com Índice

Use headings corretamente:

```markdown
## Seção Principal       ← Aparece no índice
Conteúdo da seção...

### Subseção            ← Aparece indentado
Conteúdo da subseção...
```

### Imagens

- Use imagens de no máximo 1200px de largura
- Formatos: JPG, PNG, WebP
- O WordPress já faz lazy loading automático

### Performance

- Instale plugin de cache
- Otimize imagens antes de fazer upload
- Use CDN para arquivos estáticos (opcional)

## Problemas Comuns

### Tema não aparece

```bash
# Verifique permissões
docker compose exec wordpress chown -R www-data:www-data /var/www/html/wp-content/themes/helpdocs
```

### Feedback não funciona

1. Verifique se a tabela foi criada:
   - PHPMyAdmin > wp_helpdocs_feedback
2. Limpe o cache do navegador
3. Verifique console do navegador (F12)

### Índice não aparece

1. Certifique-se que o post está na categoria "Manuais"
2. Use H2 e H3 no conteúdo
3. Não use apenas H1

## Suporte

- **Documentação completa**: Ver README.md
- **Issues**: Reportar no repositório Git
- **Email**: suporte@faculdadedunamis.com.br

---

**HelpDocs** - Pronto para usar! 🚀
