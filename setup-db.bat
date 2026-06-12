@echo off
cd /d "%~dp0"
if not exist "database\database.sqlite" type nul > "database\database.sqlite"
php artisan migrate --force
php artisan db:seed --force
echo.
echo Database siap! Jalankan: php artisan serve
pause
