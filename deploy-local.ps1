# Script Helper untuk Deployment Lokal
# Jalankan script ini sebelum push ke GitHub

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  Hostinger Deployment Helper" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Step 1: Build Assets
Write-Host "[1/4] Building assets..." -ForegroundColor Yellow
npm run build

if ($LASTEXITCODE -ne 0) {
    Write-Host "ERROR: Build failed!" -ForegroundColor Red
    exit 1
}

Write-Host "✓ Assets built successfully" -ForegroundColor Green
Write-Host ""

# Step 2: Verify build folder
Write-Host "[2/4] Verifying build folder..." -ForegroundColor Yellow
if (Test-Path "public\build\manifest.json") {
    Write-Host "✓ Build folder exists" -ForegroundColor Green
} else {
    Write-Host "ERROR: Build folder not found!" -ForegroundColor Red
    Write-Host "Please run 'npm run build' manually" -ForegroundColor Red
    exit 1
}
Write-Host ""

# Step 3: Check .env is not committed
Write-Host "[3/4] Checking .env file..." -ForegroundColor Yellow
$gitStatus = git status --porcelain .env 2>&1
if ($gitStatus -match "\.env") {
    Write-Host "WARNING: .env file is tracked by git!" -ForegroundColor Red
    Write-Host "Make sure .env is in .gitignore" -ForegroundColor Red
} else {
    Write-Host "✓ .env is properly ignored" -ForegroundColor Green
}
Write-Host ""

# Step 4: Show git status
Write-Host "[4/4] Git status:" -ForegroundColor Yellow
git status --short
Write-Host ""

# Summary
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  Ready for Deployment!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Next steps:" -ForegroundColor Yellow
Write-Host "1. Review changes: git status" -ForegroundColor White
Write-Host "2. Add changes: git add ." -ForegroundColor White
Write-Host "3. Commit: git commit -m 'Ready for Hostinger deployment'" -ForegroundColor White
Write-Host "4. Push: git push origin main" -ForegroundColor White
Write-Host ""
Write-Host "Then follow: ReadmeFile/HOSTINGER_DEPLOYMENT_STEPS.md" -ForegroundColor Cyan
Write-Host ""




