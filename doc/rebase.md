# 合并分支

### 查看log

```
git log
```

### 开始变基

#### 分别是commits的hash值，即从之前到之后之间的commits(不包含之前)都将被合并 使用squash 融合到前一个提交

```
git rebase -i SHA1 SHA1
```

### 如果有错误可以回退

```
git rebase --abort
```

### 将 master 分支指向当前头指针的位置

```
git branch -f master HEAD
```

### 合并到原分支

```
git push -f
```
