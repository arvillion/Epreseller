<h1>
    Epreseller
</h1>

## About Epreseller

​    <img src="https://img.shields.io/badge/Epreseller-v1.0--beta-blue.svg">

- Epreseller是一款Easypanel分销管理系统程序
- Epreseller是免费的
- Epreseller看心情不定时更新
- 基于Laravel5.5开发

## Features

- 服务器管理
- 产品管理
- 服务管理
- 用户组管理
- 用户管理
- API支持，便于编写插件

## Requirements

- PHP 7.1.18+
- MySQL 5.6.40+
- Composer

## Installation

1. 将项目克隆到你的网站根目录

   ```shell
   git clone https://github.com/143kk/Epreseller.git
   ```

2. 进入你的网站根目录，输入以下命令

   ```
   composer install
   ```

3. 创建配置文件`.env`

   ```
   cp .env.example .env
   ```

   修改`.env`中的下列配置,其他不作改动

   ```
   DB_HOST=127.0.0.1 #数据库地址
   DB_PORT=3306 #数据库端口
   DB_DATABASE=homestead #数据库名
   DB_USERNAME=homestead #数据库用户名
   DB_PASSWORD=secret #数据库用户密码
   
   MAIL_DRIVER=smtp #邮箱协议，一般不用修改
   MAIL_HOST=smtp.mailtrap.io #邮箱服务器
   MAIL_PORT=2525 #端口
   MAIL_USERNAME=null #用户名
   MAIL_PASSWORD=null #邮箱授权码/密码
   MAIL_ENCRYPTION=null #加密方式，默认(null)为tls
   
   APP_NAME=Epreseller
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=http://localhost #网站地址
   ```

4. 修改目录权限

   ```
   chmod -R 755 storage/
   ```

5. 运行数据库迁移和填充数据

   ```
   php artisan migrate
   php artisan db:seed
   ```

6. 后台运行队列服务

   ```
   screen php artisan queue:work --queue=default
   ```

7. 使用laravel的伪静态规则

8. 注册管理员账户

   管理员账户ID为1，进入网站首页，注册成为第一个用户，该用户即为管理员

 ## Contributing

没写好

## Links

[星空云](https://www.6zhen.cn/)

