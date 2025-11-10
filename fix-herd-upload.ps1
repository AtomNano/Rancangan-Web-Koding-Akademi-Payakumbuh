# PowerShell Script to Fix PHP Upload Limits for Laravel Herd
# Run as Administrator

Write-Host "================================================" -ForegroundColor Cyan
Write-Host "PHP Upload Limits Fix for Laravel Herd" -ForegroundColor Cyan
Write-Host "================================================" -ForegroundColor Cyan
Write-Host ""

$herdPhpIni = "$env:USERPROFILE\.config\herd-lite\bin\php.ini"

if (-not (Test-Path $herdPhpIni)) {
    Write-Host "PHP.ini not found at: $herdPhpIni" -ForegroundColor Red
    Write-Host "Please check your Herd installation." -ForegroundColor Yellow
    exit 1
}

Write-Host "Found PHP.ini: $herdPhpIni" -ForegroundColor Green
Write-Host ""

# Backup
Write-Host "Creating backup..." -ForegroundColor Yellow
$backupPath = "$herdPhpIni.backup.$(Get-Date -Format 'yyyyMMdd_HHmmss')"
Copy-Item $herdPhpIni $backupPath
Write-Host "Backup created: $backupPath" -ForegroundColor Green
Write-Host ""

# Read current content
$content = Get-Content $herdPhpIni -Raw

# Settings to add/update
$settingsToAdd = @"
; PHP Upload Configuration - Added for large file uploads
upload_max_filesize = 100M
post_max_size = 100M
max_execution_time = 300
max_input_time = 300
memory_limit = 256M
max_file_uploads = 20

"@

# Check if settings already exist
if ($content -match 'upload_max_filesize') {
    Write-Host "Upload settings already exist. Updating..." -ForegroundColor Yellow
    
    # Replace existing settings
    $content = $content -replace 'upload_max_filesize\s*=\s*[0-9]+[KMGT]?[^\r\n]*', 'upload_max_filesize = 100M'
    $content = $content -replace 'post_max_size\s*=\s*[0-9]+[KMGT]?[^\r\n]*', 'post_max_size = 100M'
    $content = $content -replace 'max_execution_time\s*=\s*[0-9]+[^\r\n]*', 'max_execution_time = 300'
    $content = $content -replace 'max_input_time\s*=\s*[0-9]+[^\r\n]*', 'max_input_time = 300'
    $content = $content -replace 'memory_limit\s*=\s*[0-9]+[KMGT]?[^\r\n]*', 'memory_limit = 256M'
    
    Set-Content -Path $herdPhpIni -Value $content -NoNewline
    Write-Host "Settings updated!" -ForegroundColor Green
} else {
    Write-Host "Adding upload settings..." -ForegroundColor Yellow
    # Append settings
    Add-Content -Path $herdPhpIni -Value $settingsToAdd
    Write-Host "Settings added!" -ForegroundColor Green
}

Write-Host ""
Write-Host "================================================" -ForegroundColor Cyan
Write-Host "IMPORTANT: Restart Laravel Herd!" -ForegroundColor Yellow
Write-Host "================================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "To restart Herd:" -ForegroundColor Yellow
Write-Host "  1. Open Laravel Herd application" -ForegroundColor White
Write-Host "  2. Stop the service" -ForegroundColor White
Write-Host "  3. Start the service again" -ForegroundColor White
Write-Host ""
Write-Host "Or restart via command line:" -ForegroundColor Yellow
Write-Host "  herd restart" -ForegroundColor White
Write-Host ""
Write-Host "After restarting, verify with:" -ForegroundColor Yellow
Write-Host "  http://127.0.0.1:8000/check-upload-config.php" -ForegroundColor White
Write-Host "  or" -ForegroundColor White
Write-Host "  http://127.0.0.1:8000/check-php-config" -ForegroundColor White
Write-Host ""
Write-Host "Script completed!" -ForegroundColor Green
