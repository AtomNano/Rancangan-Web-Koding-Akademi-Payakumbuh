# PowerShell Script to Verify Herd PHP Configuration
Write-Host "================================================" -ForegroundColor Cyan
Write-Host "Laravel Herd PHP Configuration Check" -ForegroundColor Cyan
Write-Host "================================================" -ForegroundColor Cyan
Write-Host ""

$herdPhpIni = "$env:USERPROFILE\.config\herd-lite\bin\php.ini"

Write-Host "Checking PHP configuration..." -ForegroundColor Yellow
Write-Host ""

# Check PHP.ini file
if (Test-Path $herdPhpIni) {
    Write-Host "PHP.ini location: $herdPhpIni" -ForegroundColor Green
    $content = Get-Content $herdPhpIni -Raw
    
    Write-Host ""
    Write-Host "Current settings in php.ini:" -ForegroundColor Yellow
    
    if ($content -match 'upload_max_filesize\s*=\s*([0-9]+[KMGT]?)') {
        $uploadMax = $matches[1]
        Write-Host "  upload_max_filesize = $uploadMax" -ForegroundColor $(if ($uploadMax -ge '100M') { 'Green' } else { 'Red' })
    } else {
        Write-Host "  upload_max_filesize = NOT SET" -ForegroundColor Red
    }
    
    if ($content -match 'post_max_size\s*=\s*([0-9]+[KMGT]?)') {
        $postMax = $matches[1]
        Write-Host "  post_max_size = $postMax" -ForegroundColor $(if ($postMax -ge '100M') { 'Green' } else { 'Red' })
    } else {
        Write-Host "  post_max_size = NOT SET" -ForegroundColor Red
    }
} else {
    Write-Host "PHP.ini not found at: $herdPhpIni" -ForegroundColor Red
}

Write-Host ""
Write-Host "Active PHP settings (from running PHP):" -ForegroundColor Yellow

# Check active PHP settings
$uploadMaxActive = php -r "echo ini_get('upload_max_filesize');"
$postMaxActive = php -r "echo ini_get('post_max_size');"

Write-Host "  upload_max_filesize = $uploadMaxActive" -ForegroundColor $(if ($uploadMaxActive -ge '100M') { 'Green' } else { 'Red' })
Write-Host "  post_max_size = $postMaxActive" -ForegroundColor $(if ($postMaxActive -ge '100M') { 'Green' } else { 'Red' })

Write-Host ""
Write-Host "================================================" -ForegroundColor Cyan

if ($uploadMaxActive -lt '100M' -or $postMaxActive -lt '100M') {
    Write-Host "WARNING: Settings are too low!" -ForegroundColor Red
    Write-Host ""
    Write-Host "Action required:" -ForegroundColor Yellow
    Write-Host "  1. Edit php.ini: $herdPhpIni" -ForegroundColor White
    Write-Host "  2. Add or update:" -ForegroundColor White
    Write-Host "     upload_max_filesize = 100M" -ForegroundColor White
    Write-Host "     post_max_size = 100M" -ForegroundColor White
    Write-Host "  3. RESTART Laravel Herd" -ForegroundColor White
    Write-Host "  4. Run this script again to verify" -ForegroundColor White
} else {
    Write-Host "SUCCESS: Settings are correct!" -ForegroundColor Green
    Write-Host ""
    Write-Host "You can now upload files up to 100MB." -ForegroundColor Green
}

Write-Host ""

