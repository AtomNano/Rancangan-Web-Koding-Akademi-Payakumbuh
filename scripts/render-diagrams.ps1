<#
Render all PlantUML (.puml) files in the workspace to PNG images.
Requires: Java + plantuml.jar OR PlantUML installed on PATH.

Usage:
  pwsh -File scripts/render-diagrams.ps1 -OutDir "docs/diagrams" -PlantUmlJar "C:/tools/plantuml.jar"
#>
param(
  [Parameter(Mandatory=$true)]
  [string]$OutDir,
  [string]$PlantUmlJar
)

Set-StrictMode -Version Latest
$ErrorActionPreference = 'Stop'

function Write-Info($msg){ Write-Host "[INFO] $msg" -ForegroundColor Cyan }
function Write-Warn($msg){ Write-Host "[WARN] $msg" -ForegroundColor Yellow }
function Write-Err($msg){ Write-Host "[ERROR] $msg" -ForegroundColor Red }

$workspaceRoot = (Resolve-Path (Join-Path $PSScriptRoot '..')).Path
$absOutDir = if([System.IO.Path]::IsPathRooted($OutDir)){ $OutDir } else { Join-Path $workspaceRoot $OutDir }
if(!(Test-Path $absOutDir)){ New-Item -ItemType Directory -Path $absOutDir | Out-Null }

$pumlFiles = Get-ChildItem -Path $workspaceRoot -Filter *.puml -File
if($pumlFiles.Count -eq 0){ Write-Warn "No .puml files found."; exit 0 }

if([string]::IsNullOrWhiteSpace($PlantUmlJar)){
  Write-Warn "No PlantUML JAR provided. Attempting to run 'plantuml' from PATH."
  foreach($f in $pumlFiles){
    Write-Info "Rendering $($f.Name)"
    $dest = Join-Path $absOutDir (([System.IO.Path]::GetFileNameWithoutExtension($f.Name)) + ".png")
    & plantuml -tpng -o $absOutDir $f.FullName
  }
} else {
  if(!(Test-Path $PlantUmlJar)){ Write-Err "PlantUML jar not found: $PlantUmlJar"; exit 1 }
  foreach($f in $pumlFiles){
    Write-Info "Rendering $($f.Name) via jar"
    & java -jar $PlantUmlJar -tpng -o $absOutDir $f.FullName
  }
}

Write-Host "\nRendered PNGs in: $absOutDir" -ForegroundColor Green
