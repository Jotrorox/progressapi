# Use an official PHP image with Apache
FROM php:8.0-apache

# Copy the application code to the container
COPY src/ /var/www/html/

# Grant permissions (if needed)
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Expose port 80 for web traffic
EXPOSE 80
