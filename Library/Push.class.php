<?php

/**
 * APNS Push 类
 * @author 刘健 <59208859>
 */
class Push extends Base
{

    protected $services = array(
        'tls://gateway.push.apple.com:2195', // 开发状态服务器地址
        'tls://gateway.sandbox.push.apple.com:2195', // 产品状态服务器地址
    );

    public function __construct($params = array())
    {
        empty($params) or $this->connect($params);
    }

    public function __destruct()
    {
        $this->disconnect();
    }

    // 发送消息
    public function send($deviceToken, $alert, $badge = null, $sound = 'default')
    {
        // 组织数据
        $body['aps'] = array(
            'alert' => $alert,
            'sound' => $sound,
        );
        if (!is_null($badge)) {
            $body['aps']['badge'] = (int) $badge;
        }
        $payload = json_encode($body);
        // 打印日志
        $msg = sprintf(
            "deviceToken=%s, alert=%s, badge=%d, sound=%s",
            $deviceToken,
            $alert,
            $badge,
            $sound
        );
        log_info('push', $msg);
        // 封包
        $binary = chr(0) . pack('n', 32) . pack('H*', str_replace(' ', '', $deviceToken)) . pack('n', strlen($payload)) . $payload;
        // 发送
        $fwriteLen = @fwrite($this->socket, $binary, strlen($binary));
        // 写入失败
        if ($fwriteLen == false) {
            throw new Exception('Failed to fwrite');
        }
        return $fwriteLen;
    }

}
