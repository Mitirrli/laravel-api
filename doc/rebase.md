# 合并分支

### 查看log

```
git log
```

### 开始变基

#### 分别是commits的hash值，即从之前到之后之间的commits(不包含之前)都将被合并

```
git rebase -i SHA1 SHA1
```
