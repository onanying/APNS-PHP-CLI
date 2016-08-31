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

// 接收消息
function receive($conf)
{
    $feedback = new Feedback();
    $feedback->connect($conf);
    $data = $feedback->receive();
    if (!empty($data)) {
        // 剔除无效deviceToken

    } else {
        log_info('push', 'Not to receive data');
    }
}

// 执行 (注意：Feedback建立长连接不管用，不会持续发数据过来，定时短连接即可)
while (true) {
    try {
        receive($conf);
    } catch (Exception $e) {
        log_err('feedback', $e->getMessage());
    }
    sleep(60 * 10); // 休息一大会儿
}
