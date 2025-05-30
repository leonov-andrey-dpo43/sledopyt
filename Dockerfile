#Используем базовый образ 
FROM php:8.1-apache

#Обновляем пакеты и устанавливаем ПО
RUN apt update && \
    apt install -y libxml2-dev ca-certificates git curl unzip libcurl4 nano mc && \
    apt clean && rm -rf /var/lib/apt/lists/*

#Удаляем содержимое корневой папки по умолчанию
RUN rm -rf /var/www/html/*

RUN docker-php-ext-install dom mysqli

#Копируем исходный код приложения в корень сайта Apache
COPY ./my-app/ /var/www/html/

#Меням владельца, чтобы Apache мог читать файлы
RUN chown -R www-data:www-data /var/www/html

# Копируем конфиг Apache
COPY 000-default.conf /etc/apache2/sites-available

# Создаём каталог для скрипта обработки логов
RUN mkdir -p /scripts

# Копируем скрипт обработки логов
COPY logger.sh /scripts/

RUN mkdir -p /scripts && \
    chmod +x /scripts/logger.sh && \
    chown www-data:www-data /scripts/logger.sh

#Открываем порт 80
EXPOSE 80

#Запускаем Apache2
CMD ["apache2ctl", "-D", "FOREGROUND"]
