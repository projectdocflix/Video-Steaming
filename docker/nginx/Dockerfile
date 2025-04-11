# Use an official Nginx image
FROM nginx:stable-alpine

# Remove default Nginx configuration
RUN rm /etc/nginx/conf.d/default.conf

# Copy custom Nginx configuration
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Copy application code (specifically public directory for static assets)
# Ensure the path matches where your Laravel app code will be mounted in docker-compose
COPY --chown=nginx:nginx ./public /var/www/html/public

# Expose port 80
EXPOSE 80

# Start Nginx
CMD ["nginx", "-g", "daemon off;"]