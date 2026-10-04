@echo off
setlocal enabledelayedexpansion
set "MYSQL_BIN=C:\xampp\mysql\bin"
set "DB_NAME=ranjith_personal"
set "DB_BACKUP_NAME=sql-backup-%DB_NAME%"


title 		DB Manager - %DB_NAME%
color 57
CLS

:menu
cls
echo ============================================
echo   Database Manager - %DB_NAME%
echo ============================================
echo.
echo   [1] Backup Database (Today)
echo   [2] Restore Database (Today's Backup) NOT WORKING ! ! !
echo   [3] Restore Database (Select Date) NOT WORKING ! ! !
echo   [4] Exit
echo.
set /p CHOICE="Enter choice (1-4): "

if "%CHOICE%"=="1" goto backup
if "%CHOICE%"=="2" goto restore_today
if "%CHOICE%"=="3" goto restore_select
if "%CHOICE%"=="4" exit
goto menu

REM ==================== BACKUP ====================
:backup
echo.
@REM set "BACKUP_FOLDER=%DB_NAME%-%date:~0,2%-%date:~3,2%-%date:~6,4%"
set "BACKUP_FOLDER=%DB_BACKUP_NAME%-%date:~0,2%-%date:~3,2%-%date:~6,4%"
mkdir "%BACKUP_FOLDER%" 2>nul

echo Backing up %DB_NAME% to %BACKUP_FOLDER%\...
"%MYSQL_BIN%\mysqldump.exe" -u root %DB_NAME% > "%BACKUP_FOLDER%\%DB_NAME%.sql"

if %errorlevel% == 0 (
    echo.
    echo ✅ Backup completed successfully!
    echo    File: %BACKUP_FOLDER%\%DB_NAME%.sql
) else (
    echo.
    echo ❌ Backup failed! Error code: %errorlevel%
)
pause
goto menu

REM ==================== RESTORE TODAY ====================
:restore_today
echo.
@REM set "BACKUP_FOLDER=%BACKUP_FOLDER%-backup-%date:~0,2%-%date:~3,2%-%date:~6,4%"
@REM set "BACKUP_FILE=%BACKUP_FOLDER%\%DB_NAME%.sql"
@REM set "BACKUP_FOLDER=%DB_BACKUP_NAM%-%date:~0,2%-%date:~3,2%-%date:~6,4%"
set "BACKUP_FOLDER=%DB_BACKUP_NAME%-%date:~0,2%-%date:~3,2%-%date:~6,4%"
set "BACKUP_FILE=%BACKUP_FOLDER%\%DB_NAME%.sql"

@REM DEBUG -----------------------------------------
@REM echo BACKUP_FOLDER: %BACKUP_FOLDER% 
@REM echo BACKUP_FILE: %BACKUP_FILE%
@REM pause ..
@REM     goto menu
@REM -----------------------------------------

if not exist "%BACKUP_FILE%" (
    echo ERROR: No backup found for today!
    echo Expected: %BACKUP_FILE%
    echo.
    echo Available backups:
    @REM dir /b /ad mysql-backup-* 2>nul
    dir /b /ad %BACKUP_FOLDER%-* 2>nul
    pause
    goto menu
)

goto do_restore
REM ==================== RESTORE SELECT DATE ====================
:restore_select
cls
echo ============================================
echo   Select Backup to Restore
echo ============================================
echo.
echo   [0] Cancel
echo.

REM List all backup folders with numbers
set /a COUNT=0
for /f "delims=" %%d in ('dir /b /ad /o-n mysql-backup-* 2^>nul') do (
    set /a COUNT+=1
    set "BACKUP[!COUNT!]=%%d"
    echo   [!COUNT!] %%d
)

if %COUNT%==0 (
    echo.
    echo   No backups found!
    pause
    goto menu
)

echo.
set /p SEL="Enter backup number (0-%COUNT%): "

if "%SEL%"=="0" goto menu

if not defined BACKUP[%SEL%] (
    echo Invalid selection!
    pause
    goto restore_select
)

set "BACKUP_FOLDER=!BACKUP[%SEL%]!"
set "BACKUP_FILE=%BACKUP_FOLDER%\%DB_NAME%.sql"

if not exist "%BACKUP_FILE%" (
    echo ERROR: %BACKUP_FILE% not found!
    pause
    goto restore_select
)

goto do_restore

REM ==================== DO RESTORE ====================
:do_restore
echo.
echo Selected backup: %BACKUP_FOLDER%
echo File: %BACKUP_FILE%
echo.
set /p CONFIRM="⚠️  Overwrite '%DB_NAME%' database? (Y/N): "

if /i not "%CONFIRM%"=="Y" (
    echo Restore cancelled.
    pause
    goto menu
)

echo.
echo Restoring...
@REM "%MYSQL_BIN%\mysql.exe" -u root -e "CREATE DATABASE IF NOT EXISTS %DB_NAME%;"
@REM "%MYSQL_BIN%\mysql.exe" -u root %DB_NAME% < "%BACKUP_FILE%"

if %errorlevel% == 0 (
    echo.
    echo ✅ Restore completed successfully!
) else (
    echo.
    echo ❌ Restore failed! Error code: %errorlevel%
)
pause
goto menu