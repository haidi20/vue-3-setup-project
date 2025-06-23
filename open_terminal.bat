@echo off

:: Path ke proyek Laravel BE
set "LARAVEL_BE=D:\learns\inventory-app\BE"

:: Path ke proyek frontend
set "FRONTEND=D:\learns\inventory-app\FE"

wt.exe ^
    new-tab -d "%LARAVEL_BE%" powershell.exe -NoExit -Command "php artisan serve" ; ^
    split-pane -V -d "%LARAVEL_BE%" powershell.exe -NoExit ; ^
    split-pane -V -d "%FRONTEND%" powershell.exe -NoExit -Command "yarn watch:inter" ; ^
    split-pane -V -d "%FRONTEND%" powershell.exe -NoExit