## Docker Compose Nginx + PHP + Mysql
## Feature 
<br>
- Config:php/config
- nginx: site.conf
<br>

## Platform
- PHP

**RUN**
git clone https://github.com/apkadmin/docker_nginx_php_mysql.git
<br>
docker-compose up -d --build
<br>

<br>UnexpectedValueException
The stream or file "/var/www/storage/logs/laravel.log" could not be opened: failed to open stream: Permission denied
<br>
docker exec -it nginx-php-docker_web_1
chown -R www-data /var/www


 
 **Thank you**
  

