@echo off
:: Path ke proyek Laravel BE
set "LARAVEL_BE=D:\learns\inventory-app\BE"

:: Buka beberapa pane di Windows Terminal
wt.exe ^
    new-tab -d "%LARAVEL_BE%" powershell.exe -NoExit -Command "php artisan serve" ; ^
    split-pane -V -d "%LARAVEL_BE%" powershell.exe -NoExit ; ^
    split-pane -V -d "%LARAVEL_BE%" powershell.exe -NoExit -Command "yarn dev" ; ^
    split-pane -V -d "%LARAVEL_BE%" powershell.exe -NoExit

:: Buka file workspace utama di VS Code
code "%LARAVEL_BE%\..\inventory-app.code-workspace"

echo Proyek telah dimulai dan workspace dibuka.
pause
