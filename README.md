<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

### 本地开发

##### 克隆项目

```
git clone -b develop ssh://git@quanjingshuju.com:222/yaoxiebang2/laravel-api.git
```

##### 安装需要的包

```bash
npm i
```

##### 使用docker

```bash
docker-compose up --build -d
```

### 常用命令

#### 更新项目

```
composer update-project
```

#### 启动项目

```bash
composer serve
```

```
composer octane
```

#### 代码检查

##### 代码拷贝/粘贴检测

```
php tool/phpcpd.phar --fuzzy app
```

##### 计算代码规模和结构

```
php tool/phploc.phar app package
```

### 调试

#### 使用 telescope 进行调试

##### 在 local 环境可以访问

#### 使用 tinker 进行调试

```
php artisan tinker
```
