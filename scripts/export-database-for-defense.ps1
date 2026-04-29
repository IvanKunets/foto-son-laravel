#Requires -Version 5.1
<#
.SYNOPSIS
  Экспорт MySQL в SQL-файл для переноса на флешку (защита диплома).
  Читает DB_* из .env в корне проекта (относительно расположения скрипта).

.EXAMPLE
  .\scripts\export-database-for-defense.ps1
  .\scripts\export-database-for-defense.ps1 -OutFile "E:\defense\foto_son_dump.sql"
#>
[CmdletBinding()]
param(
    [string] $EnvFile = "",
    [string] $OutFile = "",
    [string] $MysqldumpPath = ""
)

$ErrorActionPreference = "Stop"
$projectRoot = Split-Path -Parent $PSScriptRoot
if (-not $EnvFile) { $EnvFile = Join-Path $projectRoot ".env" }

function Read-DotEnv {
    param([string] $Path)
    if (-not (Test-Path -Path $Path)) {
        throw "Файл не найден: $Path. Скопируйте .env.example в .env и заполните DB_*."
    }
    $map = @{}
    Get-Content -Path $Path -Encoding UTF8 | ForEach-Object {
        $line = $_.Trim()
        if ($line -eq "" -or $line.StartsWith("#")) { return }
        $eq = $line.IndexOf("=")
        if ($eq -lt 1) { return }
        $key = $line.Substring(0, $eq).Trim()
        $val = $line.Substring($eq + 1).Trim()
        if ($val.StartsWith('"') -and $val.EndsWith('"')) { $val = $val.Substring(1, $val.Length - 2) }
        $map[$key] = $val
    }
    return $map
}

function Find-Mysqldump {
    param([string] $Explicit)
    if ($Explicit -and (Test-Path -LiteralPath $Explicit)) { return $Explicit }
    $cmd = Get-Command mysqldump -ErrorAction SilentlyContinue
    if ($cmd) { return $cmd.Source }
    $laragon = "C:\laragon\bin\mysql"
    if (Test-Path $laragon) {
        $found = Get-ChildItem -Path $laragon -Filter mysqldump.exe -Recurse -ErrorAction SilentlyContinue |
            Select-Object -First 1 -ExpandProperty FullName
        if ($found) { return $found }
    }
    throw "mysqldump не найден. Укажите -MysqldumpPath полный путь к mysqldump.exe (Laragon: ...\mysql\...\bin\mysqldump.exe) или добавьте bin MySQL в PATH."
}

$envMap = Read-DotEnv -Path $EnvFile
$db = $envMap["DB_DATABASE"]
$user = $envMap["DB_USERNAME"]
$pass = $envMap["DB_PASSWORD"]
$host_ = if ($envMap["DB_HOST"]) { $envMap["DB_HOST"] } else { "127.0.0.1" }
$port = if ($envMap["DB_PORT"]) { $envMap["DB_PORT"] } else { "3306" }

if (-not $db -or -not $user) {
    throw "В .env должны быть заданы DB_DATABASE и DB_USERNAME."
}

if (-not $OutFile) {
    $outDir = Join-Path $projectRoot "defense-export"
    if (-not (Test-Path $outDir)) { New-Item -ItemType Directory -Path $outDir | Out-Null }
    $OutFile = Join-Path $outDir "foto_son_dump.sql"
}

$mysqldump = Find-Mysqldump -Explicit $MysqldumpPath
$argList = @(
    "--host=$host_",
    "--port=$port",
    "--user=$user",
    "--single-transaction",
    "--routines",
    "--events",
    "--add-drop-table",
    $db
)
if ($pass -ne "") {
    $env:MYSQL_PWD = $pass
}

Write-Host "Export DB $db to $OutFile"
$errFile = Join-Path ([System.IO.Path]::GetTempPath()) ("mysqldump-" + [Guid]::NewGuid().ToString() + ".err")
try {
    $proc = Start-Process -FilePath $mysqldump -ArgumentList $argList -RedirectStandardOutput $OutFile -RedirectStandardError $errFile -NoNewWindow -Wait -PassThru
    if ($proc.ExitCode -ne 0) {
        $errText = ""
        if (Test-Path -LiteralPath $errFile) { $errText = Get-Content -LiteralPath $errFile -Raw }
        throw ("mysqldump exit " + $proc.ExitCode + " " + $errText)
    }
}
finally {
    Remove-Item Env:\MYSQL_PWD -ErrorAction SilentlyContinue
    if (Test-Path -LiteralPath $errFile) { Remove-Item -LiteralPath $errFile -Force -ErrorAction SilentlyContinue }
}
Write-Host "Done. Copy the SQL file to your USB drive with the project."
