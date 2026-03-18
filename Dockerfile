FROM php:8.1-apache

# Copy project files to web root
COPY . /var/www/html/

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html/

# Expose port 80
EXPOSE 80