<#
Create EA Project (.eap) from workspace assets
- Creates a new .eap file via Sparx EA COM automation
- Imports existing XMI packages (EA_* .xmi)
- Creates Admin Module packages and placeholder Activity diagrams based on .puml filenames

Prerequisites:
- Windows
- Sparx Enterprise Architect installed (COM registered: EA.Repository)
- Run PowerShell as a user that can access EA

Usage:
  pwsh -File scripts/create-ea-project.ps1 -Output "EA/CodingAkademi.eap"

Optional:
  Render PlantUML images first via scripts/render-diagrams.ps1 for reference.
#>
param(
  [Parameter(Mandatory=$true)]
  [string]$Output,
  [string]$ModelName = "E-Learning Coding Akademi Payakumbuh",
  [string]$AdminModuleName = "Admin Module"
)

Set-StrictMode -Version Latest
$ErrorActionPreference = 'Stop'

function Write-Info($msg){ Write-Host "[INFO] $msg" -ForegroundColor Cyan }
function Write-Warn($msg){ Write-Host "[WARN] $msg" -ForegroundColor Yellow }
function Write-Err($msg){ Write-Host "[ERROR] $msg" -ForegroundColor Red }

# Resolve paths
$workspaceRoot = (Resolve-Path (Join-Path $PSScriptRoot '..')).Path
$absOutput = if([System.IO.Path]::IsPathRooted($Output)){ $Output } else { Join-Path $workspaceRoot $Output }
$absOutputDir = Split-Path -Parent $absOutput
if(!(Test-Path $absOutputDir)){ New-Item -ItemType Directory -Path $absOutputDir | Out-Null }

# Ensure EA COM is available
Write-Info "Checking for Sparx EA COM automation..."
try {
  $ea = New-Object -ComObject EA.Repository
} catch {
  Write-Err "Sparx EA COM automation not found. Please install Enterprise Architect."
  Write-Err "Cannot create .eap without EA installed."
  exit 1
}

# Create project file
Write-Info "Creating EA project at: $absOutput"
try {
  $created = $ea.CreateProject($absOutput)
  if(-not $created){
    Write-Warn "CreateProject returned false; attempting to open existing file if present."
    if(Test-Path $absOutput){ $ea.OpenFile($absOutput) } else { throw "Failed to create/open $absOutput" }
  } else {
    $ea.OpenFile($absOutput)
  }
} catch {
  Write-Err "Failed to create/open EA project: $($_.Exception.Message)"
  $ea.Exit()
  [System.Runtime.Interopservices.Marshal]::ReleaseComObject($ea) | Out-Null
  exit 1
}

# Helper: Add a root model (top-level package)
function New-RootModel([string]$name){
  $pkg = $ea.Models.AddNew($name, "")
  if(-not $pkg.Update()){ Write-Warn "Update() returned false for root model '$name'" }
  $ea.Models.Refresh()
  return $pkg
}

# Helper: Add a subpackage
function New-SubPackage($parentPkg, [string]$name){
  $sub = $parentPkg.Packages.AddNew($name, "Package")
  if(-not $sub.Update()){ Write-Warn "Update() returned false for subpackage '$name'" }
  $parentPkg.Packages.Refresh()
  return $sub
}

# Helper: Create a diagram (Activity)
function New-ActivityDiagram($pkg, [string]$name){
  $dgm = $pkg.Diagrams.AddNew($name, "Activity")
  if(-not $dgm.Update()){ Write-Warn "Update() returned false for diagram '$name'" }
  $pkg.Diagrams.Refresh()
  return $dgm
}

# Helper: Import XMI into a package
function Import-XMI($pkg, [string]$xmiPath){
  if(!(Test-Path $xmiPath)){ Write-Warn "XMI not found: $xmiPath"; return }
  $proj = $ea.GetProjectInterface()
  Write-Info "Importing XMI into package '$($pkg.Name)': $xmiPath"
  # XMIType: 2 corresponds to XMI 2.1 (common EA setting)
  $result = $proj.ImportPackageXMI($pkg.PackageGUID, (Resolve-Path $xmiPath).Path, 2)
  if(-not $result){ Write-Warn "ImportPackageXMI reported failure for $xmiPath" } else { Write-Info "Imported: $xmiPath" }
}

# Build structure
Write-Info "Creating root model and core packages..."
$rootModel = New-RootModel $ModelName

# Architecture packages (import existing XMI if present)
$archPkg = New-SubPackage $rootModel "Enterprise Architecture"
$busPkg  = New-SubPackage $archPkg "Business Architecture"
$appPkg  = New-SubPackage $archPkg "Application Architecture"
$dataPkg = New-SubPackage $archPkg "Data Architecture"
$techPkg = New-SubPackage $archPkg "Technology Architecture"

Import-XMI $busPkg  (Join-Path $workspaceRoot "EA_BUSINESS_ARCHITECTURE.xmi")
Import-XMI $appPkg  (Join-Path $workspaceRoot "EA_APPLICATION_ARCHITECTURE.xmi")
Import-XMI $dataPkg (Join-Path $workspaceRoot "EA_DATA_ARCHITECTURE.xmi")
Import-XMI $techPkg (Join-Path $workspaceRoot "EA_TECHNOLOGY_ARCHITECTURE.xmi")

# Admin module packages
Write-Info "Creating Admin Module structure..."
$adminRoot = New-SubPackage $rootModel $AdminModuleName
$adminUseCases = New-SubPackage $adminRoot "Use Cases"
$adminActivity = New-SubPackage $adminRoot "Activity Diagrams"

# Create Activity diagrams from .puml filenames (placeholders)
Write-Info "Scanning PlantUML files to scaffold diagrams..."
$pumlFiles = Get-ChildItem -Path $workspaceRoot -Filter *.puml -File | Sort-Object Name

foreach($f in $pumlFiles){
  $name = [System.IO.Path]::GetFileNameWithoutExtension($f.Name)
  # Place most admin activities under Activity Diagrams
  $diagram = New-ActivityDiagram $adminActivity $name
}

# Finalize
Write-Info "Saving and closing EA project..."
$ea.SaveAll()
$ea.CloseFile()
$ea.Exit()
[System.Runtime.Interopservices.Marshal]::ReleaseComObject($ea) | Out-Null

Write-Host "\nSuccess: EA project created at $absOutput" -ForegroundColor Green
Write-Host "Open the file in Enterprise Architect to view imported packages and scaffolded diagrams." -ForegroundColor Green
