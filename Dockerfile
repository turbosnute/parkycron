FROM php:7.4-apache
COPY src/ /var/www/html
RUN apt-get update && apt-get install -qq \
    cron \
    vim
# Cron lines
RUN echo "* * * * * www-data echo 'Hello Word' > /var/www/html/test.txt" >> /etc/crontab
# Change CMD to have cron running
RUN echo "#!/bin/sh\ncron\n/usr/local/bin/apache2-foreground" > /usr/bin/run
RUN chmod u+x /usr/bin/run
RUN mkdir /data
RUN chown :www-data /data
RUN chmod 777 /data

CMD ["run"]