# Script untuk menemukan lokasi mysqldump.exe di Windows

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  Mencari mysqldump.exe..." -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

$found = $false

# Lokasi umum untuk dicari
$paths = @(
    "C:\xampp\mysql\bin",
    "C:\laragon\bin\mysql",
    "C:\Program Files\MySQL",
    "C:\Program Files (x86)\MySQL",
    "$env:LOCALAPPDATA\Programs\herd\bin\mysql\bin"
)

Write-Host "Mencari di lokasi umum..." -ForegroundColor Yellow
foreach ($basePath in $paths) {
    if (Test-Path $basePath) {
        $files = Get-ChildItem -Path $basePath -Filter "mysqldump.exe" -Recurse -ErrorAction SilentlyContinue -Depth 3
        if ($files) {
            foreach ($file in $files) {
                Write-Host "Ditemukan: $($file.FullName)" -ForegroundColor Green
                $found = $true
                
                # Test apakah bisa dijalankan
                try {
                    $version = & $file.FullName --version 2>&1
                    Write-Host "  Versi: $version" -ForegroundColor Cyan
                    
                    # Ambil folder bin
                    $binPath = $file.DirectoryName
                    Write-Host ""
                    Write-Host "========================================" -ForegroundColor Green
                    Write-Host "  PATH UNTUK .env:" -ForegroundColor Green
                    Write-Host "========================================" -ForegroundColor Green
                    Write-Host "MYSQL_DUMP_PATH=$binPath" -ForegroundColor Yellow
                    Write-Host ""
                    Write-Host "Copy baris di atas ke file .env" -ForegroundColor Cyan
                    Write-Host ""
                } catch {
                    Write-Host "  Tidak bisa dijalankan" -ForegroundColor Red
                }
            }
        }
    }
}

# Jika tidak ditemukan
if (-not $found) {
    Write-Host "mysqldump.exe tidak ditemukan di lokasi umum!" -ForegroundColor Red
    Write-Host ""
    Write-Host "Coba cari manual:" -ForegroundColor Yellow
    Write-Host "1. Buka File Explorer" -ForegroundColor White
    Write-Host "2. Cari 'mysqldump.exe' di drive C:" -ForegroundColor White
    Write-Host "3. Copy path folder 'bin' (bukan file .exe)" -ForegroundColor White
    Write-Host ""
    Write-Host "Atau gunakan backup files saja:" -ForegroundColor Yellow
    Write-Host "php artisan backup:run --only-files" -ForegroundColor Cyan
}

Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  Selesai" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
