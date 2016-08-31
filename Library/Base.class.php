<?php

/**
 * APNS 基类
 * @author 刘健 <59208859>
 */
abstract class Base
{

    protected $socket; // socket 资源

    protected $services; // 服务器url

    protected $servicesSelect = 0; // 选择的url项次

    // 使用ssl协议建立tcp连接
    public function connect($params = array())
    {
        // 初始化tcp配置
        $stream = stream_context_create();
        stream_context_set_option($stream, 'ssl', 'local_cert', $params['local_cert']);
        stream_context_set_option($stream, 'ssl', 'passphrase', $params['passphrase']);
        // 建立连接
        $this->socket = stream_socket_client($this->services[$this->servicesSelect], $err, $errStr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $stream);
        if (!$this->socket) {
            throw new Exception("Failed to connect: {$err} {$errStr}");
        }
    }

    // 关闭连接
    public function disconnect()
    {
        fclose($this->socket);
    }

}
