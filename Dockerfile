#Используем базовый образ Debian
FROM debian

#Обновляем пакеты и устанавливаем Apache, PHP, MySQL
RUN apt update && \
    apt install -y apache2 apache2-utils php php-cli php-mysql && \
    apt clean

#Удаляем содержимое корневой папки по умолчанию
RUN rm -rf /var/www/html/*

#Копируем исходный код приложения в корень сайта Apache
COPY . /var/www/html/

#Меням владельца, чтобы Apache мог читать файлы
RUN chown -R www-data:www-data /var/www/html

#Открываем порт 80
EXPOSE 80

#Запускаем Apache
CMD ["apache2ctl", "-D", "FOREGROUND"]
