# WebStack
WordPress 版 WebStack 主题
<br/>

### 首页截图
<br/>

![Thumbnail_index](https://res.iowen.cn/wp-content/uploads/2019/08/iowen_2019-08-27_01-05-39.png)
<br/>

### 环境要求
+ WordPress 4.4+
+ WordPress 伪静态
+ PHP 5.7+ 7.0+
<br/>

### 安装指南
+ 安装 WordPress ，教程百度
+ 设置伪静态
```
# Nginx规则
location /
{
    try_files $uri $uri/ /index.php?$args;
}
rewrite /wp-admin$ $scheme://$host$uri/ permanent;

# Apache 规则
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
```
+ WordPress 后台「主题」栏目 -> 上传主题 -> 启用主题，或者在 /wp-content/themes 文件夹新建webstack文件夹，并上传所有文件
+ 果然点击地址出现404，请到WordPress 后台「设置」栏目 -> 固定链接 -> 保存更改
+ 反馈交♂流：<a href="https://www.iowen.cn" target="_blank">一为忆</a>

<br/>

### 主题使用
+ 在 WordPress 后台“网址”文章类型下添加内容
+ 分类最多两级，且父级不要添加内容
+ 可以不添加网址图片，主题会自动获取目标网址的 favicon 图标
+ 导航菜单栏标题前面的图标请在分类图像描述中填入（参考下图），图标样式请参考fontawesome
![Thumbnail_index](https://res.iowen.cn/wp-content/uploads/2019/08/Snipaste_2019-08-30_13-43-06.png)
+ 导航菜单栏下方可以添加自定义菜单，在后台的外观-->菜单里设置，在菜单的css类添加图标（参考下图），图标样式请参考fontawesome
![Thumbnail_index](https://res.iowen.cn/wp-content/uploads/2019/08/Snipaste_2019-08-30_13-50-59.png)
+ <a href="https://www.iowen.cn/wordpress-version-webstack/" target="_blank">其他-></a>
<br/>

### 后台截图
<br/>

![Thumbnail_index](https://res.iowen.cn/wp-content/uploads/2019/08/iowen_2019-08-27_01-22-37.jpg)
![Thumbnail_index](https://res.iowen.cn/wp-content/uploads/2019/08/iowen_2019-08-27_01-27-48.png)
<br/>

### 感谢
感谢 <a href="https://github.com/WebStackPage/WebStackPage.github.io" target="_blank">Viggo</a> 的前台设计
<br/>

### 更新
<a href="https://github.com/owen0o0/WebStack/releases" target="_blank">更新日志</a>
