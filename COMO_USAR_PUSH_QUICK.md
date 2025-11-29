# Como Usar o Script push:quick

## ✅ Script Configurado e Funcionando!

O comando `npm run push:quick` agora está funcionando corretamente.

## 📋 O que o script faz:

1. ✅ Adiciona todos os arquivos modificados (`git add .`)
2. ✅ Faz commit automático com timestamp
3. ✅ Tenta fazer push para o GitHub
4. ✅ Se houver conflito, faz pull automaticamente e tenta push novamente

## 🚀 Uso Simples:

```bash
npm run push:quick
```

## ⚠️ Se houver conflitos:

Se o script encontrar conflitos que não consegue resolver automaticamente, ele vai te avisar e você pode fazer manualmente:

```bash
git pull origin main
# Resolva os conflitos se houver
git push origin main
```

## 📝 Outros Scripts NPM Disponíveis:

- `npm run push` - Apenas push (sem commit)
- `npm run pull` - Apenas pull do GitHub
- `npm run status` - Ver status do Git
- `npm run add` - Adicionar todos os arquivos

## 💡 Dica:

Use `npm run push:quick` sempre que quiser fazer uma atualização rápida no GitHub com todas as suas mudanças locais!

