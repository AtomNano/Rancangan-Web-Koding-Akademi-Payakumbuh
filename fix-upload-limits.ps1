# PowerShell Script to Fix PHP Upload Limits (Windows)
# Run as Administrator if needed

Write-Host "================================================" -ForegroundColor Cyan
Write-Host "PHP Upload Limits Fix Script (Windows)" -ForegroundColor Cyan
Write-Host "================================================" -ForegroundColor Cyan
Write-Host ""

# Find PHP installation
$phpIniPath = $null

# Common XAMPP paths
$xamppPaths = @(
    "C:\xampp\php\php.ini",
    "D:\xampp\php\php.ini",
    "E:\xampp\php\php.ini"
)

# Common WAMP paths
$wampPaths = @(
    "C:\wamp64\bin\php\php8.2\php.ini",
    "C:\wamp64\bin\php\php8.1\php.ini",
    "C:\wamp64\bin\php\php8.0\php.ini",
    "C:\wamp\bin\php\php8.2\php.ini",
    "C:\wamp\bin\php\php8.1\php.ini",
    "C:\wamp\bin\php\php8.0\php.ini"
)

Write-Host "Searching for php.ini file..." -ForegroundColor Yellow

# Try to find php.ini using php command
try {
    $phpCommand = Get-Command php -ErrorAction SilentlyContinue
    if ($phpCommand) {
        $phpInfo = php --ini 2>&1
        if ($phpInfo -match "Loaded Configuration File:\s+(.+)") {
            $phpIniPath = $matches[1]
            Write-Host "Found php.ini via php command: $phpIniPath" -ForegroundColor Green
        }
    }
} catch {
    Write-Host "PHP command not found in PATH" -ForegroundColor Yellow
}

# If not found, check common paths
if (-not $phpIniPath) {
    $allPaths = $xamppPaths + $wampPaths
    foreach ($path in $allPaths) {
        if (Test-Path $path) {
            $phpIniPath = $path
            Write-Host "Found php.ini: $phpIniPath" -ForegroundColor Green
            break
        }
    }
}

# If still not found, ask user
if (-not $phpIniPath) {
    Write-Host "Could not find php.ini automatically." -ForegroundColor Red
    $phpIniPath = Read-Host "Please enter the full path to php.ini"
    
    if (-not (Test-Path $phpIniPath)) {
        Write-Host "File not found: $phpIniPath" -ForegroundColor Red
        exit 1
    }
}

Write-Host ""
Write-Host "Backing up php.ini..." -ForegroundColor Yellow
$backupPath = "$phpIniPath.backup.$(Get-Date -Format 'yyyyMMdd_HHmmss')"
Copy-Item $phpIniPath $backupPath
Write-Host "Backup created: $backupPath" -ForegroundColor Green

Write-Host ""
Write-Host "Reading php.ini..." -ForegroundColor Yellow
$content = Get-Content $phpIniPath -Raw

# Settings to change
$settings = @{
    'upload_max_filesize\s*=\s*[0-9]+[KMGT]?' = 'upload_max_filesize = 100M'
    'post_max_size\s*=\s*[0-9]+[KMGT]?' = 'post_max_size = 100M'
    'max_execution_time\s*=\s*[0-9]+' = 'max_execution_time = 300'
    'max_input_time\s*=\s*[0-9]+' = 'max_input_time = 300'
    'memory_limit\s*=\s*[0-9]+[KMGT]?' = 'memory_limit = 256M'
}

Write-Host ""
Write-Host "Updating settings..." -ForegroundColor Yellow
$changed = $false

foreach ($pattern in $settings.Keys) {
    $replacement = $settings[$pattern]
    if ($content -match $pattern) {
        $oldValue = $matches[0]
        $content = $content -replace $pattern, $replacement
        Write-Host "  Changed: $oldValue -> $replacement" -ForegroundColor Green
        $changed = $true
    } else {
        # If setting doesn't exist, add it
        if ($content -notmatch $replacement) {
            # Try to find a good place to add it (after other settings)
            if ($content -match '(upload_max_filesize|post_max_size|max_execution_time)') {
                # Add after the last setting match
                $content = $content -replace "($pattern|upload_max_filesize|post_max_size|max_execution_time|max_input_time|memory_limit)", "`$1`n$replacement"
            } else {
                # Add in the upload section
                $content = $content -replace "(\[PHP\])", "`$1`n$replacement"
            }
            Write-Host "  Added: $replacement" -ForegroundColor Green
            $changed = $true
        }
    }
}

if ($changed) {
    Write-Host ""
    Write-Host "Saving changes..." -ForegroundColor Yellow
    Set-Content -Path $phpIniPath -Value $content -NoNewline
    Write-Host "Changes saved successfully!" -ForegroundColor Green
    
    Write-Host ""
    Write-Host "================================================" -ForegroundColor Cyan
    Write-Host "IMPORTANT: Restart Apache/Web Server!" -ForegroundColor Yellow
    Write-Host "================================================" -ForegroundColor Cyan
    Write-Host ""
    Write-Host "To restart Apache:" -ForegroundColor Yellow
    Write-Host "  1. Open XAMPP/WAMP Control Panel" -ForegroundColor White
    Write-Host "  2. Stop Apache" -ForegroundColor White
    Write-Host "  3. Start Apache" -ForegroundColor White
    Write-Host ""
    Write-Host "Or use this command (if Apache is installed as service):" -ForegroundColor Yellow
    Write-Host "  net stop apache2.4" -ForegroundColor White
    Write-Host "  net start apache2.4" -ForegroundColor White
    Write-Host ""
    Write-Host "After restarting, verify with:" -ForegroundColor Yellow
    Write-Host "  http://localhost/check-upload-config.php" -ForegroundColor White
} else {
    Write-Host "No changes needed. Settings are already correct." -ForegroundColor Green
}

Write-Host ""
Write-Host "Script completed!" -ForegroundColor Cyan

