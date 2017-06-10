# Laravel 5.4 todo application


> ### Vagrant and VirtualBox
>
> Vagrant Setup used: [Homestead(5.3.2)](https://github.com/laravel/homestead/releases/tag/v5.3.2)


### Nginx setup
Nginx Config file.
Create a virtual host configuration file for your project under `/path/to/nginx/sites-enabled/todo.dev`
it should look something like below:
```nginx.conf
server {
    listen 80;
    server_name todo.dev;
    root "/vagrant/code/todo/public";

    index index.html index.htm index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    access_log off;
    error_log  /var/log/nginx/todo-error.log error;

    sendfile off;

    client_max_body_size 10m;

    location ~ \.php$ {
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/var/run/php/php7.1-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        

        fastcgi_intercept_errors off;
        fastcgi_buffer_size 16k;
        fastcgi_buffers 4 16k;
        fastcgi_connect_timeout 300;
        fastcgi_send_timeout 300;
        fastcgi_read_timeout 300;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

### To install
1. Clone the repository
2. Setup db credentials in .env file
3. Install dependencies: `composer install`
4. Run Migrations: `php artisan migrate`
5. Seed the DB: `php artisan seed`
6. Setup the server

### Demo users

username: admin@gmail.com
password: adminuser

username: user@gmail.com
password: demouser