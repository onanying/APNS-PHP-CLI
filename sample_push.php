<?php

(php_sapi_name() == 'cli') or die('Please run under the cli');

// 资源文件
include 'autoload.php';
include 'log.php';

// 证书配置
$conf = array(
    'local_cert' => 'ck.pem',
    'passphrase' => '123456',
);

// 发送消息
function send($conf)
{
    $push = new Push();
    $push->connect($conf);
    while (true) {
        // 从数据库取出待发送的消息
		# code ..
        // 发送
        $push->send('ad07852bc07894be55d798fa5128987bb85387f606d3be4df7365a18063ce3d1', '一条新消息', 8);
    }
}

// 执行
while (true) {
    try {
        send($conf);
    } catch (Exception $e) {
        log_err('push', $e->getMessage());
        sleep(5); // 休息一小会儿
    }
}
