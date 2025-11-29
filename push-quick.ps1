# Script PowerShell para push rápido
# Uso: npm run push:quick

Write-Host ""
Write-Host "Fazendo push rapido..." -ForegroundColor Cyan
Write-Host ""

# Adicionar todos os arquivos primeiro
Write-Host "Adicionando arquivos..." -ForegroundColor Yellow
git add . 2>&1 | Out-Null

# Verificar se há mudanças para commit
$status = git status --porcelain
if (-not $status) {
    Write-Host "Nenhuma mudanca para fazer commit." -ForegroundColor Yellow
    Write-Host "Tudo atualizado!" -ForegroundColor Green
    Write-Host ""
    exit 0
}

# Fazer commit
Write-Host "Fazendo commit..." -ForegroundColor Yellow
$timestamp = Get-Date -Format "yyyy-MM-dd HH:mm:ss"
git commit -m "Update: mudancas rapidas - $timestamp" 2>&1 | Out-Null

# Tentar push
Write-Host "Fazendo push para GitHub..." -ForegroundColor Yellow
git push origin main 2>&1 | Out-Null

# Verificar se push funcionou
if ($LASTEXITCODE -eq 0) {
    Write-Host "Push concluido com sucesso!" -ForegroundColor Green
    Write-Host ""
} else {
    Write-Host ""
    Write-Host "O repositorio remoto tem alteracoes. Fazendo pull primeiro..." -ForegroundColor Yellow
    Write-Host ""
    
    # Fazer pull com merge
    Write-Host "Buscando alteracoes do GitHub..." -ForegroundColor Yellow
    git pull origin main --no-rebase 2>&1 | Out-Null
    
    if ($LASTEXITCODE -eq 0) {
        Write-Host "Tentando push novamente..." -ForegroundColor Yellow
        git push origin main 2>&1 | Out-Null
        
        if ($LASTEXITCODE -eq 0) {
            Write-Host "Push concluido com sucesso!" -ForegroundColor Green
            Write-Host ""
        } else {
            Write-Host ""
            Write-Host "Ainda ha conflitos. Execute manualmente:" -ForegroundColor Red
            Write-Host "   git pull origin main" -ForegroundColor Yellow
            Write-Host "   git push origin main" -ForegroundColor Yellow
            Write-Host ""
            exit 1
        }
    } else {
        Write-Host ""
        Write-Host "Erro ao fazer pull. Execute manualmente:" -ForegroundColor Red
        Write-Host "   git pull origin main" -ForegroundColor Yellow
        Write-Host "   git push origin main" -ForegroundColor Yellow
        Write-Host ""
        exit 1
    }
}
