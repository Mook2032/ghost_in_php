Project for ITSS_AS_K56 @ HUST @ 20141

[![Build Status](https://travis-ci.org/yuyuvn/ghost_in_php.svg?branch=master)](https://github.com/c633/ghost_in_php)


### Configuration

1. create new file with called `.env.local.php`
2. create new database (e.g. `itss`)
3. create new mysql user and grant privilege to this user
4. edit `.env.local.php` 
```
<?php
return array(
  'database' => 'your_database_name',
  'database_user' => 'your_user',
  'database_password' => 'your_secure_password'
);
```
5. find in the file `bootstrap/start.php` the following lines
```
$env = $app->detectEnvironment(array(

	'local' => array('c633'),

));
```

add to this array your `hostname` (you can run `hostname` command on your terminal to see your hostname).
it maybe look like this after your editing
```

$env = $app->detectEnvironment(array(

	'local' => array('c633', 'your_hostname_comes_here'),

));
```

### Setup Environment
1. Install `apache`
2. Config virtual host
- domain: ghost.dev
- `DocumentRoot` points to: `your/path/to/project/folder/PUBLIC`
e.g.
```
<VirtualHost *:80>
        DocumentRoot "path/to/laravel/project/public"
        ServerName cg.dev
        <Directory "path/to/laravel/project/public">
                Options Indexes FollowSymLinks
                AllowOverride All
                Order allow,deny
                Allow from all
        </Directory>
</VirtualHost>
```

3. Set access permission on folder `app/storage` for `apache`
Run following commands
```
cd path/to/your/laravel/project/
sudo chown -R www-data app/storage
```

4. browse to `ghost.dev` to check if we have installed successfully
![](http://i.imgur.com/A74thKv.png)
