FROM wordpress:6.4

RUN a2enmod ssl && a2enmod rewrite && a2enmod headers

COPY apache/wordpress.conf /etc/apache2/sites-available/wordpress.conf

RUN a2dissite 000-default \
 && a2ensite wordpress


