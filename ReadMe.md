# phpQiniuAdmin

An Qiniu Web Admin GUI make by php.

> 比较简单,各位见谅,主要用户刷新文件.


## 使用

1. `composer install`
2. 在 `config` 文件下 新建 `production` 文件夹, 将 `config/config.php` 复制到 `config/production/config.php`
3. 修改 `config/production/config.php` 的配置
4. 配置服务器, nginx 配置如下:

```
server {
    listen 80;
    root html/phpQiniuAdmin/public;
    index index.php index.html index.htm;
    server_name phpQiniuAdmin.dev;
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    location ~ \.php$ {
        try_files $uri /index.php =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

5. 运行 , enjoy.
