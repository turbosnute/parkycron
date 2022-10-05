FROM php:7.4-apache
RUN apt-get update && apt-get install -qq \
    cron \
    vim
COPY src/ /var/www/html
# Cron lines
RUN echo "0 * * * * www-data php /var/www/html/reauth.php" >> /etc/crontab
# Change CMD to have cron running
RUN echo "#!/bin/sh\ncron\n/usr/local/bin/apache2-foreground" > /usr/bin/run
RUN chmod u+x /usr/bin/run
RUN mkdir /data
RUN chown :www-data /data
RUN chmod 777 /data
RUN touch /data/db.sqlite
RUN chmod 777 /data/db.sqlite

CMD ["run"]