@echo off
REM === CONFIGURAÇÕES ===
set DB_PATH=minha_base.sqlite
set SQL_SCRIPT=idk.sql
set SQLITE_EXE=DB_UTILS/sqlite3.exe

REM === VERIFICAR SE A BASE EXISTE ===
if exist %DB_PATH% (
    echo O ficheiro %DB_PATH% já existe.
    set /p CONFIRM="Queres mesmo apagar e recriar? (s/n): "
    if /I "%CONFIRM%" NEQ "s" (
        echo Operação cancelada pelo utilizador.
        pause
        exit /b
    )
    echo Apagando base de dados antiga...
    del /f %DB_PATH%
) else (
    echo Nenhuma base existente encontrada. A criar nova...
)

REM === CRIAR NOVA BASE DE DADOS COM O SCRIPT ===
echo Criando nova base de dados a partir de: %SQL_SCRIPT%
%SQLITE_EXE% %DB_PATH% < %SQL_SCRIPT%

REM === FINAL ===
echo Operação concluída.
pause
