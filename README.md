<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

### 本地开发

##### 创建项目

```bash
composer create-project mitirrli/laravel-api -vvv
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

##### cli

```bash
composer serve
```

##### octane

```
composer octane
```

#### 模型缓存

##### 清除指定模型的缓存

```
php artisan modelCache:clear --model=App\Model
```

### 调试

#### telescope

##### 路径

```
{{url}}/telescope
```

#### tinker

##### 使用

```
php artisan tinker
```
