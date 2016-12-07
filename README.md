# APNS-PHP-CLI

PHP版本iOS消息推送APNS；分为Push、Feedback两部分：Push负责消息推送，Feedback负责清理过期的deviceToken；APNS我踩了很多坑，原因是对APNS的了解不够透彻，加上恶心的苹果不提供错误反馈；我先后使用了C++、PHP两种语言来开发APNS，其中PHP的socket封装的非常好用，可以很简单的实现功能；C++版本的APNS网上很少开源，待我完善后再开源，请叫我雷锋。

### 感谢 (Thanks)

本项目的 Feedback 类，参考了开源项目 https://github.com/immobiliare/ApnsPHP 

### 范例 (Sample)

	sample_push.php 
	sample_feedback.php

### 运行 (Run)

在cli模式下运行

```
// Windows
php sample_push.php
php sample_feedback.php

// Linux (可脱离终端)
nohup php sample_push.php >/dev/null 2>&1 &
nohup php sample_feedback.php >/dev/null 2>&1 &
```