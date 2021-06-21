## yxb_main tables message
#### 1、 yxb_news_share
资讯分享表

| 序号 | 名称 | 描述 | 类型 | 键 | 为空 | 额外 | 默认值 |
| :--: | :--: | :--: | :--: | :--: | :--: | :--: | :--: |
| 1 | `id` | 分享id | bigint(20) unsigned | PRI | NO | auto_increment |  |
| 2 | `uid` | 用户id | int(11) |  | NO |  | 0 |
| 3 | `new_id` | 资讯id | int(11) |  | NO |  | 0 |
| 4 | `product_id` | 产品id | int(11) |  | NO |  | 0 |
| 5 | `create_time` | 创建时间 | int(10) unsigned |  | NO |  |  |


#### 2、 yxb_news_tag
资讯标签表

| 序号 | 名称 | 描述 | 类型 | 键 | 为空 | 额外 | 默认值 |
| :--: | :--: | :--: | :--: | :--: | :--: | :--: | :--: |
| 1 | `id` | 标签id | bigint(20) unsigned | PRI | NO | auto_increment |  |
| 2 | `name` | 标签名 | varchar(20) |  | NO |  |  |
| 3 | `sort` | 排序: 由大到小 | int(10) unsigned |  | NO |  | 0 |
| 4 | `online_time` | 上线时间: 0表示未上线 | int(10) unsigned |  | NO |  | 0 |
| 5 | `create_time` | 创建时间 | int(10) unsigned |  | NO |  |  |
| 6 | `delete_time` | 删除时间 | int(10) unsigned |  | YES |  |  |


#### 3、 yxb_news
资讯表

| 序号 | 名称 | 描述 | 类型 | 键 | 为空 | 额外 | 默认值 |
| :--: | :--: | :--: | :--: | :--: | :--: | :--: | :--: |
| 1 | `id` | 咨讯id | bigint(20) unsigned | PRI | NO | auto_increment |  |
| 2 | `tag_id` | 标签id | int(11) |  | NO |  | 0 |
| 3 | `title_img` | 标题图 | varchar(150) |  | NO |  |  |
| 4 | `title` | 资讯标题 | varchar(30) |  | NO |  |  |
| 5 | `description` | 资讯简介 | varchar(30) |  | NO |  |  |
| 6 | `content` | 资讯内容 | text |  | NO |  |  |
| 7 | `reproduce_url` | 转载url | varchar(150) |  | NO |  |  |
| 8 | `online_time` | 上线时间: 0表示未上线 | int(10) unsigned |  | NO |  | 0 |
| 9 | `top_time` | 置顶时间 | int(10) unsigned |  | NO |  | 0 |
| 10 | `create_time` | 创建时间 | int(10) unsigned |  | NO |  |  |
| 11 | `update_time` | 更新时间 | int(10) unsigned |  | NO |  |  |
| 12 | `delete_time` | 删除时间 | int(10) unsigned |  | YES |  |  |


