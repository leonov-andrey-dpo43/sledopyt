#!/bin/bash

# Создаём файл, если его нет
touch "$CUSTOM_LOG_DIR"

# Читаем логи
while read log; do
    echo "$log" | awk '{print $4 " " $1}' >> "$CUSTOM_LOG_DIR"
done 

exec > /dev/null 2>&1