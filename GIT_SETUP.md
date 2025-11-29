# Configuração Git - Projeto Padaria

## ✅ Configuração Realizada

O repositório Git foi configurado para trabalhar com:
- **Repositório**: https://github.com/eduabjr/projeto-padaria
- **Branch principal**: `main`
- **Remote**: `origin`

## 📋 Comandos Git Principais

### Fazer Pull (Buscar alterações do GitHub)
```bash
git pull origin main
```

### Fazer Push (Enviar alterações para o GitHub)
```bash
git push origin main
```

### Primeiro Commit e Push
Se você ainda não fez o primeiro commit:

```bash
# Adicionar todos os arquivos
git add .

# Fazer o commit inicial
git commit -m "Initial commit: organização completa do projeto"

# Fazer push para o GitHub
git push -u origin main
```

### Fluxo de Trabalho Diário

1. **Buscar alterações do GitHub:**
   ```bash
   git pull origin main
   ```

2. **Verificar status:**
   ```bash
   git status
   ```

3. **Adicionar arquivos modificados:**
   ```bash
   git add .
   # ou arquivos específicos:
   git add arquivo1.php arquivo2.html
   ```

4. **Fazer commit:**
   ```bash
   git commit -m "Descrição das mudanças"
   ```

5. **Enviar para o GitHub:**
   ```bash
   git push origin main
   ```

## 🔧 Configuração Adicional

### Verificar configuração do usuário Git
```bash
git config user.name
git config user.email
```

### Configurar usuário (se necessário)
```bash
git config user.name "Seu Nome"
git config user.email "seu.email@exemplo.com"
```

### Verificar remote configurado
```bash
git remote -v
```

## 📝 Arquivo .gitignore

Foi criado um arquivo `.gitignore` que exclui:
- `node_modules/`
- Arquivos de configuração local (`.env`)
- Arquivos temporários
- Arquivos de IDEs

## ⚠️ Notas Importantes

- Sempre faça `git pull` antes de `git push` para evitar conflitos
- Use mensagens de commit descritivas
- O branch principal é `main`
- O remote está configurado como `origin`

