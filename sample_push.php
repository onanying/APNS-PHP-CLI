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
           
        # code ...
        
        // 发送
        $push->send($data['token'], '收到一条新消息', $data['badge']);
    }
}

// 执行
while (true) {
    try {
        send($conf);
    } catch (Exception $e) {
        log_err('push', $e->getMessage());
    }
}
