#!/bin/bash

# Создаём файл, если его нет
touch "$CUSTOM_LOG"

# Читаем логи
while read log; do
    echo "$log" | awk '{print $4 " " $1}' >> CUSTOM_LOG
done