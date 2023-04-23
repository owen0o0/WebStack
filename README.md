# WebStack
WordPress 版 WebStack 主题。<a href="http://webstack.iotheme.cn/">前往演示站</a>
<br/>

### 声明
当你使用 WebStack 主题发布文章、文字、图片、视频等内容均属于你自己的行为，你的这些行为所带来的安全或法律风险均需自行承担。


“Webstack Pro”是作者在19年尝试的一个收费项目，现已不在维护支持，且与<a href="https://github.com/WebStackPage/WebStackPage.github.io" target="_blank">Viggo</a>无关，应当时名字欠缺考虑，给<a href="https://github.com/WebStackPage/WebStackPage.github.io" target="_blank">Viggo</a>带来了不必要的麻烦，在此道歉。<br/>
现今网络上流传的“Webstack Pro”版本均为盗用作者19年的内容，与作者和<a href="https://github.com/WebStackPage/WebStackPage.github.io" target="_blank">Viggo</a>无关。

### 首页截图
<br/>

![Thumbnail_index](https://owen0o0.github.io/ioStaticResources/webstack/01.png)
<br/>

### 环境要求
+ WordPress 4.4+
+ WordPress 伪静态
+ PHP 5.7+ 7.0+
<br/>

### 安装指南
+ 安装 WordPress ，教程百度
+ 设置伪静态（下方规则按自己服务器环境二选一）
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
![Thumbnail_index](https://owen0o0.github.io/ioStaticResources/webstack/02.png)
+ 增加分类快速添加图标的方法
![Thumbnail_index](https://owen0o0.github.io/ioStaticResources/webstack/07.png)
+ 导航菜单栏下方可以添加自定义菜单，在后台的外观-->菜单里设置，在菜单的css类添加图标（参考下图），图标样式请参考fontawesome
![Thumbnail_index](https://owen0o0.github.io/ioStaticResources/webstack/03.png)
+ 如果菜单里没有css类，请按下图添加
![Thumbnail_index](https://owen0o0.github.io/ioStaticResources/webstack/04.jpg)
+ <a href="https://www.iotheme.cn/store/onenav.html" target="_blank">如果你有更多功能需求，点我-></a>
<br/>

### 后台截图
<br/>

![Thumbnail_index](https://owen0o0.github.io/ioStaticResources/webstack/05.jpg)
![Thumbnail_index](https://owen0o0.github.io/ioStaticResources/webstack/06.png)
<br/>

### 感谢
感谢 <a href="https://github.com/WebStackPage/WebStackPage.github.io" target="_blank">Viggo</a> 的前台设计
<br/>

### 更新
<a href="https://github.com/owen0o0/WebStack/releases" target="_blank">更新日志</a>
更新方法为替换源文件，或者在wordpress后台删除主题，然后重新安装主题
