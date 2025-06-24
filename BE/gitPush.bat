@echo off
REM Add all changes
git add .

REM Commit with a message
set /p msg="Commit message: "
git commit -m "%msg%"

REM Push current branch to remote 'be'
git push origin be
