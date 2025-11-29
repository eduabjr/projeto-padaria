# Scripts NPM Disponíveis

## 📦 Scripts Git Configurados

### `npm run push:quick`
Executa um push rápido: adiciona todos os arquivos, faz commit e push
```bash
npm run push:quick
```
Equivale a:
```bash
git add .
git commit -m "Update: mudanças rápidas"
git push origin main
```

### `npm run push`
Apenas faz push (sem commit)
```bash
npm run push
```

### `npm run pull`
Busca alterações do GitHub
```bash
npm run pull
```

### `npm run status`
Verifica o status do repositório
```bash
npm run status
```

### `npm run add`
Adiciona todos os arquivos ao stage
```bash
npm run add
```

### `npm run commit "mensagem"`
Faz commit com mensagem personalizada
```bash
npm run commit "sua mensagem aqui"
```

## 💡 Dica

Para fazer commit com mensagem personalizada:
```bash
npm run commit "Descrição detalhada das mudanças"
git push origin main
```

Ou use o push:quick para uma atualização rápida:
```bash
npm run push:quick
```

