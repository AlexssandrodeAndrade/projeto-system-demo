@echo off
title Projeto System Demo - Ambiente de Desenvolvimento

echo ==============================================
echo Iniciando ambiente do Projeto-System-Demo...
echo ==============================================
echo.

:: Ir para a pasta do projeto
cd /d D:\projeto-system-demo

echo Iniciando servidor Laravel...
start cmd /k "php artisan serve"

echo Iniciando Vite (npm run dev)...
start cmd /k "npm run dev"

echo.
echo Ambiente iniciado com sucesso!
exit
