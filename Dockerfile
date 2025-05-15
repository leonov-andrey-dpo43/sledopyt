#Используем базовый образ 
FROM php:8.1-apache

#Обновляем пакеты и устанавливаем ПО
RUN apt update && \
    apt install -y libxml2-dev ca-certificates git curl unzip libcurl4 && \
    apt clean && rm -rf /var/lib/apt/lists/*

#Удаляем содержимое корневой папки по умолчанию
RUN rm -rf /var/www/html/*

#Копируем исходный код приложения в корень сайта Apache
COPY ./app /var/www/html/

#Меням владельца, чтобы Apache мог читать файлы
RUN chown -R www-data:www-data /var/www/html

# Копируем конфиг Apache
COPY cus-log.conf /etc/apache2/conf.d/

# Копируем скрипт обработки логов
RUN mkdir -p /scripts && \
    cp scripts/logger.sh /scripts/ && \
    chmod +x /scripts/logger.sh && \
    chown www-data:www-data /scripts/logger.sh

#Открываем порт 80
EXPOSE 80

#Запускаем Apache
CMD ["apache2ctl", "-D", "FOREGROUND"]
