# 全局安装扩展
```
$ composer global require 'mitirrli/package-builder' --prefer-source
```

# 设置设置全局路径
```
echo 'export PATH=$PATH:~/.composer/vendor/bin' >> ~/.zshrc
```

# 执行
```
source ~/.zshrc
```

# 生成扩展包
```
package-builder build
```