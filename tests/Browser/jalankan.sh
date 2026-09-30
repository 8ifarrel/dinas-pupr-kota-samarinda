#!/usr/bin/env bash
# Jalankan uji browser Hantu Banyu terhadap database pupr_smr_test.
#   bash tests/Browser/jalankan.sh <berkas-hasil.json>
set -euo pipefail
cd "$(dirname "$0")/../.."

export DB_DATABASE=pupr_smr_test
export DEBUGBAR_ENABLED=false
PORT=8191

php tests/Browser/isi-data.php 36
(cd public && exec php -S 127.0.0.1:$PORT ../vendor/laravel/framework/src/Illuminate/Foundation/resources/server.php) > /tmp/hb-browser-server.log 2>&1 &
# `kill` dari Git Bash tidak menghentikan php.exe native; hentikan lewat PowerShell.
henti() { powershell -NoProfile -Command "Get-CimInstance Win32_Process -Filter \"Name='php.exe'\" | Where-Object { \$_.CommandLine -like '*127.0.0.1:$PORT*' } | ForEach-Object { Stop-Process -Id \$_.ProcessId -Force }" || true; }
trap henti EXIT
for i in $(seq 1 50); do curl -s -o /dev/null "http://127.0.0.1:$PORT/" && break; sleep 0.2; done

BASE_URL="http://127.0.0.1:$PORT" node tests/Browser/hantu-banyu.cjs "${1:-hasil-browser.json}"
