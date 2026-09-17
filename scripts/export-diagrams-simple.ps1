# Export All PlantUML Diagrams to PNG
# Simple script that works with VS Code PlantUML extension

param(
    [string]$OutputDir = "exported_diagrams"
)

$workspaceRoot = Split-Path -Parent $PSScriptRoot
$outputPath = Join-Path $workspaceRoot $OutputDir

# Create output directory
if (!(Test-Path $outputPath)) {
    New-Item -ItemType Directory -Path $outputPath | Out-Null
    Write-Host "Created output directory: $outputPath" -ForegroundColor Green
}

# Find all .puml files
$pumlFiles = Get-ChildItem -Path $workspaceRoot -Filter "*.puml" -File | Sort-Object Name

if ($pumlFiles.Count -eq 0) {
    Write-Host "No .puml files found!" -ForegroundColor Red
    exit 1
}

Write-Host "`nFound $($pumlFiles.Count) PlantUML files" -ForegroundColor Cyan
Write-Host "=" * 60

# Check if PlantUML extension is available in VS Code
$vscodeExtension = code --list-extensions | Select-String "jebbs.plantuml"

if (!$vscodeExtension) {
    Write-Host "`nWARNING: PlantUML extension not found in VS Code!" -ForegroundColor Yellow
    Write-Host "Please install: jebbs.plantuml extension" -ForegroundColor Yellow
    Write-Host "`nAlternative: Use online PlantUML server" -ForegroundColor Cyan
    Write-Host "Visit: http://www.plantuml.com/plantuml/uml/" -ForegroundColor Cyan
}

# Group files by category
$categories = @{
    "Admin Activity" = @()
    "Admin Module" = @()
    "Guru Module" = @()
    "Siswa Module" = @()
    "Enterprise Architecture" = @()
    "Use Case" = @()
}

foreach ($file in $pumlFiles) {
    $name = $file.Name
    
    if ($name -like "ADMIN_ACTIVITY_*") {
        $categories["Admin Activity"] += $file
    }
    elseif ($name -like "ADMIN_MODULE_*") {
        $categories["Admin Module"] += $file
    }
    elseif ($name -like "GURU_MODULE_*") {
        $categories["Guru Module"] += $file
    }
    elseif ($name -like "SISWA_MODULE_*") {
        $categories["Siswa Module"] += $file
    }
    elseif ($name -like "EA_*") {
        $categories["Enterprise Architecture"] += $file
    }
    elseif ($name -like "USE_CASE_*") {
        $categories["Use Case"] += $file
    }
}

# Display summary
Write-Host "`nDiagram Summary:" -ForegroundColor Green
Write-Host "-" * 60
foreach ($category in $categories.Keys | Sort-Object) {
    $count = $categories[$category].Count
    if ($count -gt 0) {
        Write-Host "  $category : $count files" -ForegroundColor Cyan
    }
}

Write-Host "`n" + "=" * 60
Write-Host "EXPORT INSTRUCTIONS:" -ForegroundColor Yellow
Write-Host "=" * 60

Write-Host "`nOption 1: Export via VS Code (Recommended)" -ForegroundColor Green
Write-Host "  1. Open any .puml file in VS Code"
Write-Host "  2. Press Alt+D to preview"
Write-Host "  3. Right-click on preview → 'Export Current Diagram'"
Write-Host "  4. Choose PNG/SVG format"
Write-Host "  5. Save to: $outputPath"

Write-Host "`nOption 2: Export All at Once" -ForegroundColor Green
Write-Host "  1. Press Ctrl+Shift+P"
Write-Host "  2. Type: 'PlantUML: Export Workspace Diagrams'"
Write-Host "  3. Choose output format (PNG recommended)"
Write-Host "  4. Diagrams will be exported automatically"

Write-Host "`nOption 3: Online PlantUML Server" -ForegroundColor Green
Write-Host "  1. Open: http://www.plantuml.com/plantuml/uml/"
Write-Host "  2. Copy-paste .puml file content"
Write-Host "  3. Download as PNG/SVG"

Write-Host "`n" + "=" * 60
Write-Host "Files to Export:" -ForegroundColor Cyan
Write-Host "=" * 60

$index = 1
foreach ($category in $categories.Keys | Sort-Object) {
    if ($categories[$category].Count -gt 0) {
        Write-Host "`n[$category]" -ForegroundColor Yellow
        foreach ($file in $categories[$category] | Sort-Object Name) {
            Write-Host "  $index. $($file.Name)" -ForegroundColor White
            $index++
        }
    }
}

Write-Host "`n" + "=" * 60
Write-Host "Total: $($pumlFiles.Count) diagrams ready to export" -ForegroundColor Green
Write-Host "Output directory: $outputPath" -ForegroundColor Green
Write-Host "=" * 60

# Create a README in output directory
$readmePath = Join-Path $outputPath "README.md"
$readmeContent = @"
# Exported PlantUML Diagrams

Generated from: E-Learning Coding Akademi Payakumbuh
Date: $(Get-Date -Format "yyyy-MM-dd HH:mm:ss")

## Diagram Categories

### Admin Activity Diagrams ($($categories["Admin Activity"].Count) files)
Detailed activity diagrams for admin operations:
- User Management (Add, Edit, Delete, Activate/Deactivate)
- Class Management (Create, Edit, Delete, Enroll, Unenroll)
- Meeting & Attendance (Create, Input Attendance)
- Material Verification (Approve, Reject)
- Backup & Export

### Module Diagrams
- **Admin Module**: $($categories["Admin Module"].Count) files
- **Guru Module**: $($categories["Guru Module"].Count) files
- **Siswa Module**: $($categories["Siswa Module"].Count) files

### Enterprise Architecture ($($categories["Enterprise Architecture"].Count) files)
- Business Architecture
- Application Architecture
- Data Architecture
- Technology Architecture

### Use Case Diagrams ($($categories["Use Case"].Count) files)
- System-wide use case diagrams

## How to Export

### Via VS Code:
1. Install PlantUML extension (jebbs.plantuml)
2. Open .puml file
3. Press Alt+D to preview
4. Right-click → Export Current Diagram
5. Save as PNG/SVG to this directory

### Via Command:
``````powershell
# Export all diagrams
Ctrl+Shift+P → "PlantUML: Export Workspace Diagrams"
``````

## File Naming Convention

- `ADMIN_ACTIVITY_*.puml` - Admin activity diagrams
- `ADMIN_MODULE_*.puml` - Admin module use cases
- `GURU_MODULE_*.puml` - Guru module use cases
- `SISWA_MODULE_*.puml` - Siswa module use cases
- `EA_*.puml` - Enterprise architecture diagrams
- `USE_CASE_*.puml` - Use case diagrams

---
**Total Diagrams**: $($pumlFiles.Count)
"@

Set-Content -Path $readmePath -Value $readmeContent -Encoding UTF8
Write-Host "`nCreated README.md in output directory" -ForegroundColor Green

Write-Host "`nDone! 🎉" -ForegroundColor Green
