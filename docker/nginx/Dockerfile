#docker/nginx/Dockerfile
FROM nginx:1.21-alpine

COPY default.conf  /etc/nginx/conf.d/
COPY templates /etc/nginx/templates/
RUN echo "upstream php-upstream { server php:9000; }" > /etc/nginx/conf.d/upstream.conf

EXPOSE 80
EXPOSE 443