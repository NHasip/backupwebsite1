param(
  [string]$HostName = '127.0.0.1',
  [int]$Port = 8080
)

$root = Split-Path -Parent $MyInvocation.MyCommand.Path
$wpPath = Join-Path $root 'wordpress'

Set-Location $wpPath
Write-Host "WordPress gestart op http://$HostName`:$Port"
php -S "$HostName`:$Port" router.php
