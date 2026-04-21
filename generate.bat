@echo off
setlocal

set ROOT=C:\laragon\www\BlendPath
set OUTPUT=%ROOT%\structure.txt

echo Generating Laravel structure...
echo. > "%OUTPUT%"

REM ===============================
REM APP
REM ===============================
echo ===== APP ===== >> "%OUTPUT%"
cd /d "%ROOT%\app"
dir /s >> "%OUTPUT%"
echo. >> "%OUTPUT%"

REM ===============================
REM MIGRATIONS
REM ===============================
echo ===== MIGRATIONS ===== >> "%OUTPUT%"
cd /d "%ROOT%\database\migrations"
dir /s >> "%OUTPUT%"
echo. >> "%OUTPUT%"

REM ===============================
REM ALL VIEWS (INI YANG KAMU MAU)
REM ===============================
echo ===== ALL VIEWS ===== >> "%OUTPUT%"
cd /d "%ROOT%\resources\views"
dir /s >> "%OUTPUT%"
echo. >> "%OUTPUT%"

echo Done!
pause