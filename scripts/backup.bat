@echo off
REM HRM Database Backup Script (Windows)
REM Usage: backup.bat

setlocal enabledelayedexpansion

set BACKUP_DIR=%BACKUP_DIR:C:\backups%
set DB_USER=%DB_USER:hrm_user%
set DB_NAME=%DB_NAME:hrm%
set BACKUP_FILE=%BACKUP_DIR%\hrm_%date:~10,4%-%date:~4,2%-%date:~7,2%_%time:~0,2%-%time:~3,2%-%time:~6,2%.sql

if not exist "%BACKUP_DIR%" (
  mkdir "%BACKUP_DIR%"
)

echo Backing up %DB_NAME% to %BACKUP_FILE%...
mysqldump -u %DB_USER% -p %DB_NAME% > "%BACKUP_FILE%"

if !errorlevel! equ 0 (
  echo Backup completed: %BACKUP_FILE%
) else (
  echo Backup failed!
  exit /b 1
)

endlocal
