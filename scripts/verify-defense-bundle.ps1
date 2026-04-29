#Requires -Version 5.1
<#
.SYNOPSIS
  Checks project readiness for USB/offline demo (PHP, vendor, .env, storage link).
#>
[CmdletBinding()]
param([string] $ProjectRoot = "")

$ErrorActionPreference = "Continue"
if (-not $ProjectRoot) { $ProjectRoot = Split-Path -Parent $PSScriptRoot }

$ok = $true

function Step {
    param([string] $Title)
    Write-Host ""
    Write-Host ($Title) -ForegroundColor Cyan
}

Step "=== PHP ==="
$v = php -r "echo PHP_VERSION;"
if (-not $v) {
    Write-Host "  PHP not in PATH" -ForegroundColor Yellow
    $ok = $false
} else {
    Write-Host "  Version: $v"
    $parts = $v.Split(".")
    $major = [int]$parts[0]
    $minor = [int]$parts[1]
    if ($major -lt 8 -or ($major -eq 8 -and $minor -lt 3)) {
        Write-Host "  Need PHP 8.3+" -ForegroundColor Yellow
        $ok = $false
    } else {
        Write-Host "  OK"
    }
}

Step "=== vendor ==="
$vendor = Join-Path $ProjectRoot "vendor\autoload.php"
if (-not (Test-Path $vendor)) {
    Write-Host "  Missing vendor/autoload.php" -ForegroundColor Yellow
    $ok = $false
} else {
    Write-Host "  OK"
}

Step "=== .env ==="
$envFile = Join-Path $ProjectRoot ".env"
if (-not (Test-Path $envFile)) {
    Write-Host "  No .env file" -ForegroundColor Yellow
    $ok = $false
} else {
    Write-Host "  OK"
}

Step "=== APP_KEY ==="
if (Test-Path $envFile) {
    $content = Get-Content -LiteralPath $envFile -Raw
    if ($content -notmatch "APP_KEY=base64:") {
        Write-Host "  Run: php artisan key:generate" -ForegroundColor Yellow
        $ok = $false
    } else {
        Write-Host "  OK"
    }
}

Step "=== public/storage link ==="
$pub = Join-Path $ProjectRoot "public\storage"
if (-not (Test-Path $pub)) {
    Write-Host "  Run: php artisan storage:link" -ForegroundColor Yellow
    $ok = $false
} else {
    Write-Host "  OK"
}

Step "=== storage/app/public files ==="
$uploads = Join-Path $ProjectRoot "storage\app\public"
if (-not (Test-Path $uploads)) {
    Write-Host "  Folder missing" -ForegroundColor Yellow
    $ok = $false
} else {
    $n = (Get-ChildItem -LiteralPath $uploads -Recurse -File -ErrorAction SilentlyContinue | Measure-Object).Count
    Write-Host "  File count: $n"
    if ($n -eq 0) {
        Write-Host "  Add gallery media before demo if you need uploads." -ForegroundColor Yellow
    }
}

Write-Host ""
if ($ok) {
    Write-Host "All checks passed. Try: php artisan serve" -ForegroundColor Green
    exit 0
}
Write-Host "Fix the issues above before the defense demo." -ForegroundColor Yellow
exit 1
